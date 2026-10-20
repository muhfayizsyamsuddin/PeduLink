<?php

namespace Tests\Feature;

use App\Models\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CampaignVisibilityTest extends TestCase
{
    use RefreshDatabase;

    private function createCampaign(string $status): Campaign
    {
        return Campaign::create([
            'title' => 'Test Campaign',
            'slug' => 'test-campaign-' . uniqid(),
            'description' => 'Campaign for automated testing.',
            'target_amount' => 50000000,
            'status' => $status,
        ]);
    }

    public function test_public_can_view_active_campaign(): void
    {
        $campaign = $this->createCampaign('active');

        $this->getJson('/api/campaigns/' . $campaign->id)
            ->assertOk()
            ->assertJsonPath('data.status', 'active');
    }

    public function test_public_cannot_view_draft_campaign(): void
    {
        $campaign = $this->createCampaign('draft');

        $this->getJson('/api/campaigns/' . $campaign->id)
            ->assertNotFound()
            ->assertJsonPath('status', 'error')
            ->assertJsonPath('message', 'Campaign not found.');
    }

    public function test_public_campaign_list_only_contains_active_campaigns(): void
    {
        $this->createCampaign('active');
        $this->createCampaign('draft');

        $response = $this->getJson('/api/campaigns')
            ->assertOk();

        $response->assertJsonCount(1, 'data');
        $response->assertJsonPath('data.0.status', 'active');
    }
}