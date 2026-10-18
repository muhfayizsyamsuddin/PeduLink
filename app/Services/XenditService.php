<?php

namespace App\Services;

use App\Models\Donation;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class XenditService
{
    /**
     * Create a Xendit invoice for a donation.
     *
     * @return array<string, mixed>
     */
    public function createInvoice(Donation $donation): array
    {
        $secretKey = config('services.xendit.secret_key');

        if (empty($secretKey)) {
            throw new RuntimeException(
                'Xendit secret key is not configured.'
            );
        }

        $donation->loadMissing(['campaign', 'donor']);

        $payload = [
            'external_id' => $donation->external_id,
            'amount' => (int) $donation->amount,
            'currency' => $donation->currency,
            'description' => 'Donation: ' . $donation->campaign->title,
            'invoice_duration' => 86400,
        ];

        if (! empty($donation->donor->email)) {
            $payload['payer_email'] = $donation->donor->email;
        }

        $response = Http::withBasicAuth($secretKey, '')
            ->acceptJson()
            ->timeout(20)
            ->post('https://api.xendit.co/v2/invoices', $payload);

        $response->throw();

        return $response->json();
    }
}