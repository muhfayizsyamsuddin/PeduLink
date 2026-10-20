<?php

use App\Models\Donation;
use App\Services\XenditService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home');
Route::get('/campaigns/{slug}', function (string $slug) {
    return view('campaigns.show', ['slug' => $slug]);
})->name('campaigns.show');
Route::get(
    '/donasi/hasil/{externalId}',
    function (
        string $externalId,
        XenditService $xenditService
    ) {
        $donation = Donation::with('campaign')
            ->where('external_id', $externalId)
            ->firstOrFail();

        $verificationIssue = false;

        if (filled($donation->xendit_invoice_id)) {
            try {
                $invoice = $xenditService->getInvoice(
                    $donation->xendit_invoice_id
                );

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
                    $verificationIssue = true;
                } else {
                    $invoiceStatus = strtoupper(
                        (string) ($invoice['status'] ?? '')
                    );

                    if (
                        in_array($invoiceStatus, ['PAID', 'SETTLED'], true)
                        && $donation->status !== 'paid'
                    ) {
                        $paidAt = filled($invoice['paid_at'] ?? null)
                            ? Carbon::parse($invoice['paid_at'])
                            : now();

                        $donation->update([
                            'status' => 'paid',
                            'paid_at' => $paidAt,
                        ]);
                    } elseif (
                        $invoiceStatus === 'EXPIRED'
                        && $donation->status === 'pending'
                    ) {
                        $donation->update([
                            'status' => 'expired',
                        ]);
                    }
                }
            } catch (Throwable $exception) {
                report($exception);
                $verificationIssue = true;
            }
        } else {
            $verificationIssue = true;
        }

        $donation->refresh();
        $donation->load('campaign');

        return view('donations.result', [
            'donation' => $donation,
            'verificationIssue' => $verificationIssue,
        ]);
    }
)->middleware('throttle:30,1')->name('donations.result');