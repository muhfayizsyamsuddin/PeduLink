<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Donor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Tests\TestCase;

class XenditWebhookTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.xendit.callback_token' => 'test-callback-token',
        ]);
    }

    private function createDonation(
        string $status = 'pending'
    ): Donation {
        $campaign = Campaign::create([
            'title' => 'Test Campaign',
            'slug' => 'test-campaign-' . Str::uuid(),
            'description' => 'Campaign for automated testing.',
            'target_amount' => 50000000,
            'status' => 'active',
        ]);

        $donor = Donor::create([
            'name' => 'Test Donor',
            'email' => 'donor@example.com',
            'phone' => null,
        ]);

        return Donation::create([
            'campaign_id' => $campaign->id,
            'donor_id' => $donor->id,
            'amount' => 14000,
            'currency' => 'IDR',
            'message' => null,
            'is_anonymous' => false,
            'status' => $status,
            'external_id' => 'PEDULINK-' . Str::uuid(),
            'xendit_invoice_id' => 'invoice-' . Str::uuid(),
            'xendit_invoice_url' => null,
            'paid_at' => $status === 'paid'
                ? Carbon::parse('2026-10-20T21:11:15Z')
                : null,
        ]);
    }

    public function test_paid_webhook_updates_donation(): void
    {
        $donation = $this->createDonation();

        $response = $this
            ->withHeader(
                'x-callback-token',
                'test-callback-token'
            )
            ->postJson('/api/webhooks/xendit/invoice', [
                'id' => $donation->xendit_invoice_id,
                'external_id' => $donation->external_id,
                'status' => 'PAID',
                'amount' => $donation->amount,
                'currency' => 'IDR',
                'paid_at' => '2026-10-20T21:11:15Z',
            ]);

        $response
            ->assertOk()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('message', 'Webhook processed.');

        $this->assertSame('paid', $donation->fresh()->status);
        $this->assertNotNull($donation->fresh()->paid_at);
    }

    public function test_invalid_callback_token_is_rejected(): void
    {
        $donation = $this->createDonation();

        $response = $this
            ->withHeader('x-callback-token', 'wrong-token')
            ->postJson('/api/webhooks/xendit/invoice', [
                'id' => $donation->xendit_invoice_id,
                'external_id' => $donation->external_id,
                'status' => 'PAID',
            ]);

        $response
            ->assertUnauthorized()
            ->assertJsonPath('message', 'Invalid callback token.');

        $this->assertSame('pending', $donation->fresh()->status);
    }

    public function test_expired_webhook_expires_pending_donation(): void
    {
        $donation = $this->createDonation();

        $this
            ->withHeader(
                'x-callback-token',
                'test-callback-token'
            )
            ->postJson('/api/webhooks/xendit/invoice', [
                'id' => $donation->xendit_invoice_id,
                'external_id' => $donation->external_id,
                'status' => 'EXPIRED',
                'amount' => $donation->amount,
                'currency' => 'IDR',
            ])
            ->assertOk();

        $this->assertSame('expired', $donation->fresh()->status);
    }

    public function test_expired_webhook_does_not_downgrade_paid_donation(): void
    {
        $donation = $this->createDonation('paid');
        $originalPaidAt = $donation->paid_at->toISOString();

        $this
            ->withHeader(
                'x-callback-token',
                'test-callback-token'
            )
            ->postJson('/api/webhooks/xendit/invoice', [
                'id' => $donation->xendit_invoice_id,
                'external_id' => $donation->external_id,
                'status' => 'EXPIRED',
                'amount' => $donation->amount,
                'currency' => 'IDR',
            ])
            ->assertOk();

        $donation->refresh();

        $this->assertSame('paid', $donation->status);
        $this->assertSame(
            $originalPaidAt,
            $donation->paid_at->toISOString()
        );
    }

    public function test_unknown_donation_is_acknowledged(): void
    {
        $this
            ->withHeader(
                'x-callback-token',
                'test-callback-token'
            )
            ->postJson('/api/webhooks/xendit/invoice', [
                'id' => 'unknown-invoice',
                'external_id' => 'unknown-donation',
                'status' => 'PAID',
            ])
            ->assertOk()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath(
                'message',
                'Webhook acknowledged; no matching donation found.'
            );
    }

    public function test_paid_webhook_with_wrong_amount_does_not_update_donation(): void
    {
        $donation = $this->createDonation();

        $this
            ->withHeader('x-callback-token', 'test-callback-token')
            ->postJson('/api/webhooks/xendit/invoice', [
                'id' => $donation->xendit_invoice_id,
                'external_id' => $donation->external_id,
                'status' => 'PAID',
                'amount' => 14001,
                'currency' => 'IDR',
            ])
            ->assertOk()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath(
                'message',
                'Webhook acknowledged; invoice details did not match donation.'
            );

        $donation->refresh();

        $this->assertSame('pending', $donation->status);
        $this->assertNull($donation->paid_at);
    }

    public function test_paid_webhook_with_wrong_currency_does_not_update_donation(): void
    {
        $donation = $this->createDonation();

        $this
            ->withHeader('x-callback-token', 'test-callback-token')
            ->postJson('/api/webhooks/xendit/invoice', [
                'id' => $donation->xendit_invoice_id,
                'external_id' => $donation->external_id,
                'status' => 'PAID',
                'amount' => $donation->amount,
                'currency' => 'USD',
            ])
            ->assertOk()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath(
                'message',
                'Webhook acknowledged; invoice details did not match donation.'
            );

        $donation->refresh();

        $this->assertSame('pending', $donation->status);
        $this->assertNull($donation->paid_at);
    }
}