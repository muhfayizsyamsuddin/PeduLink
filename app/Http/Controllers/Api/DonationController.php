<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use App\Services\XenditService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
}