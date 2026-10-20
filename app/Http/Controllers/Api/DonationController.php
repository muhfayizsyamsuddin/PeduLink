<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use App\Services\XenditService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use RuntimeException;
use Throwable;

class DonationController extends Controller
{
    /**
     * Create a donation and generate a Xendit invoice.
     */
    public function store(
        Request $request,
        XenditService $xenditService
    ): JsonResponse {
        $validated = $request->validate([
            'campaign_id' => [
                'required',
                'integer',
                'exists:campaigns,id',
            ],
            'donor_id' => [
                'required',
                'integer',
                'exists:donors,id',
            ],
            'amount' => ['required', 'integer', 'min:1'],
            'message' => ['nullable', 'string', 'max:2000'],
            'is_anonymous' => ['sometimes', 'boolean'],
        ]);

        $campaign = Campaign::findOrFail(
            $validated['campaign_id']
        );

        if ($campaign->status !== 'active') {
            return response()->json([
                'status' => 'error',
                'message' => 'This campaign is not accepting donations.',
            ], 422);
        }

        // Do not create a transaction if Xendit is not configured.
        if (blank(config('services.xendit.secret_key'))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment service is not configured.',
            ], 503);
        }

        $donation = Donation::create([
            'campaign_id' => $validated['campaign_id'],
            'donor_id' => $validated['donor_id'],
            'amount' => $validated['amount'],
            'currency' => 'IDR',
            'message' => $validated['message'] ?? null,
            'is_anonymous' => $validated['is_anonymous'] ?? false,
            'status' => 'pending',
            'external_id' => 'PEDULINK-' . Str::uuid(),
        ]);

        try {
            $invoice = $xenditService->createInvoice($donation);

            $invoiceId = $invoice['id'] ?? null;
            $invoiceUrl = $invoice['invoice_url'] ?? null;

            if (blank($invoiceId) || blank($invoiceUrl)) {
                throw new RuntimeException(
                    'Xendit response did not contain the required invoice fields.'
                );
            }

            $donation->update([
                'xendit_invoice_id' => $invoiceId,
                'xendit_invoice_url' => $invoiceUrl,
            ]);
        } catch (Throwable $exception) {
            $donation->update([
                'status' => 'failed',
            ]);

            report($exception);

            return response()->json([
                'status' => 'error',
                'message' => 'Unable to create the payment invoice. Please try again later.',
                'data' => [
                    'donation_id' => $donation->id,
                    'payment_status' => 'failed',
                ],
            ], 502);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Donation created. Complete your payment using the invoice URL.',
            'data' => [
                'id' => $donation->id,
                'campaign_id' => $donation->campaign_id,
                'donor_id' => $donation->donor_id,
                'amount' => $donation->amount,
                'currency' => $donation->currency,
                'status' => $donation->status,
                'external_id' => $donation->external_id,
                'xendit_invoice_id' => $donation->xendit_invoice_id,
                'payment_url' => $donation->xendit_invoice_url,
            ],
        ], 201);
    }

    /**
 * Display donation transactions.
 */
public function index(): JsonResponse
{
    $donations = Donation::query()
        ->with([
            'campaign:id,title',
            'donor:id,name',
        ])
        ->latest()
        ->paginate(15);

    return response()->json([
        'status' => 'success',
        'message' => 'Donations retrieved successfully.',
        'data' => $donations,
    ]);
}

    /**
     * Display a single donation transaction.
     */
    public function show(Donation $donation): JsonResponse
    {
        $donation->load([
            'campaign:id,title',
            'donor:id,name',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Donation retrieved successfully.',
            'data' => [
                'id' => $donation->id,
                'campaign' => $donation->campaign,
                'donor' => $donation->donor,
                'amount' => $donation->amount,
                'currency' => $donation->currency,
                'message' => $donation->message,
                'is_anonymous' => $donation->is_anonymous,
                'status' => $donation->status,
                'external_id' => $donation->external_id,
                'xendit_invoice_id' => $donation->xendit_invoice_id,
                'xendit_invoice_url' => $donation->xendit_invoice_url,
                'paid_at' => $donation->paid_at,
                'created_at' => $donation->created_at,
            ],
        ]);
    }

    /**
     * Synchronize donation status with Xendit.
     */
    public function syncStatus(
        Donation $donation,
        XenditService $xenditService
    ): JsonResponse {
        if (blank($donation->xendit_invoice_id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'This donation has no Xendit invoice.',
            ], 422);
        }

        try {
            $invoice = $xenditService->getInvoice(
                $donation->xendit_invoice_id
            );
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json([
                'status' => 'error',
                'message' => 'Unable to retrieve invoice status from Xendit.',
            ], 502);
        }

        // Verify that the invoice belongs to this donation.
        $identityMatches =
            ($invoice['id'] ?? null) === $donation->xendit_invoice_id
            && ($invoice['external_id'] ?? null) === $donation->external_id
            && (int) ($invoice['amount'] ?? 0) === (int) $donation->amount;

        $invoiceCurrency = strtoupper(
            (string) ($invoice['currency'] ?? '')
        );

        $currencyMatches = $invoiceCurrency === ''
            || $invoiceCurrency === strtoupper($donation->currency);

        if (! $identityMatches || ! $currencyMatches) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invoice details do not match this donation.',
            ], 409);
        }

        $xenditStatus = strtoupper(
            (string) ($invoice['status'] ?? '')
        );

        if (in_array($xenditStatus, ['PAID', 'SETTLED'], true)) {
            // Never downgrade or rewrite a previously paid donation.
            if ($donation->status !== 'paid') {
                $paidAt = filled($invoice['paid_at'] ?? null)
                    ? Carbon::parse($invoice['paid_at'])
                    : now();

                $donation->update([
                    'status' => 'paid',
                    'paid_at' => $paidAt,
                ]);
            }
        } elseif (
            $xenditStatus === 'EXPIRED'
            && $donation->status === 'pending'
        ) {
            $donation->update([
                'status' => 'expired',
            ]);
        }

        $donation->refresh();

        return response()->json([
            'status' => 'success',
            'message' => 'Donation status synchronized.',
            'data' => [
                'donation_id' => $donation->id,
                'xendit_status' => $xenditStatus,
                'donation_status' => $donation->status,
                'paid_at' => $donation->paid_at,
            ],
        ]);
    }
}