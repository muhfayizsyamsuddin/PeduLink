<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login_and_receive_token(): void
    {
        $password = 'PeduLink-Test-123!';

        User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@example.test',
            'password' => Hash::make($password),
            'role' => 'admin',
        ]);

        $this->postJson('/api/auth/login', [
            'email' => 'admin@example.test',
            'password' => $password,
        ])
            ->assertOk()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.user.role', 'admin')
            ->assertJsonPath('data.token_type', 'Bearer')
            ->assertJsonStructure([
                'data' => ['token'],
            ]);

        $this->assertDatabaseHas('personal_access_tokens', [
            'name' => 'pedulink-admin',
        ]);
    }

    public function test_non_admin_cannot_login(): void
    {
        $password = 'PeduLink-Test-123!';

        User::factory()->create([
            'email' => 'user@example.test',
            'password' => Hash::make($password),
            'role' => 'user',
        ]);

        $this->postJson('/api/auth/login', [
            'email' => 'user@example.test',
            'password' => $password,
        ])
            ->assertForbidden()
            ->assertJsonPath(
                'message',
                'You are not authorized as an admin.'
            );

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    public function test_invalid_password_is_rejected(): void
    {
        User::factory()->create([
            'email' => 'admin@example.test',
            'password' => Hash::make('Correct-Password-123!'),
            'role' => 'admin',
        ]);

        $this->postJson('/api/auth/login', [
            'email' => 'admin@example.test',
            'password' => 'Wrong-Password-123!',
        ])
            ->assertUnauthorized()
            ->assertJsonPath('message', 'Invalid credentials.');
    }

    public function test_logout_revokes_current_token(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $token = $user->createToken('test-token');
        $tokenId = $token->accessToken->id;

        $this->withToken($token->plainTextToken)
            ->postJson('/api/auth/logout')
            ->assertOk()
            ->assertJsonPath('message', 'Logout successful.');

        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => $tokenId,
        ]);

        // Reset cached authentication state before simulating a new request.
        $this->app['auth']->forgetGuards();

        $this->withToken($token->plainTextToken)
            ->getJson('/api/user')
            ->assertUnauthorized();
    }
}