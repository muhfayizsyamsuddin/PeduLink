<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class XenditWebhookController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        $expectedToken = config('services.xendit.callback_token');
        $receivedToken = $request->header('x-callback-token');

        if (blank($expectedToken)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Webhook verification is not configured.',
            ], 503);
        }

        if (
            ! is_string($receivedToken) ||
            ! hash_equals($expectedToken, $receivedToken)
        ) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid callback token.',
            ], 401);
        }

        $invoiceId = $request->input('id');
        $externalId = $request->input('external_id');

        $donation = null;

        if (filled($invoiceId)) {
            $donation = Donation::where(
                'xendit_invoice_id',
                $invoiceId
            )->first();
        }

        if (! $donation && filled($externalId)) {
            $donation = Donation::where(
                'external_id',
                $externalId
            )->first();
        }

        if (! $donation) {
            Log::warning(
                'Verified Xendit webhook received without matching donation.',
                [
                    'invoice_id' => $invoiceId,
                    'external_id' => $externalId,
                    'invoice_status' => $request->input('status'),
                ]
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Webhook acknowledged; no matching donation found.',
            ], 200);
        }

        $payloadAmount = $request->input('amount');
        $payloadCurrency = $request->input('currency');

        $amountMatches = is_numeric($payloadAmount)
            && (float) $payloadAmount === (float) $donation->amount;

        $currencyMatches = is_string($payloadCurrency)
            && strtoupper(trim($payloadCurrency))
                === strtoupper($donation->currency);

        if (! $amountMatches || ! $currencyMatches) {
            Log::warning(
                'Verified Xendit webhook invoice details did not match donation.',
                [
                    'donation_id' => $donation->id,
                    'invoice_id' => $invoiceId,
                    'external_id' => $externalId,
                    'received_amount' => $payloadAmount,
                    'received_currency' => $payloadCurrency,
                ]
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Webhook acknowledged; invoice details did not match donation.',
            ]);
        }

        $invoiceStatus = strtoupper(
            (string) $request->input('status')
        );

        if (in_array($invoiceStatus, ['PAID', 'SETTLED'], true)) {
            $donation->update([
                'status' => 'paid',
                'paid_at' => filled($request->input('paid_at'))
                    ? Carbon::parse($request->input('paid_at'))
                    : now(),
            ]);
        } elseif ($invoiceStatus === 'EXPIRED') {
            // Do not overwrite an already confirmed payment.
            if ($donation->status === 'pending') {
                $donation->update([
                    'status' => 'expired',
                ]);
            }
        }

        Log::info('PeduLink Xendit webhook processed.', [
            'donation_id' => $donation->id,
            'invoice_status' => $invoiceStatus,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Webhook processed.',
        ]);
    }
}