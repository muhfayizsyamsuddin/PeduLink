<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_list_donations(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/donations')
            ->assertForbidden();
    }

    public function test_non_admin_cannot_create_campaigns(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/campaigns', [])
            ->assertForbidden();
    }

    public function test_public_can_view_campaigns(): void
    {
        $this->getJson('/api/campaigns')
            ->assertOk();
    }
}