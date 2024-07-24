<?php

namespace Tests\Feature\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     */
    public function test_logs_in_a_valid_user(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('login', [
            'email' => $user->email,
            'password' => 'password',
        ]));

        $response
            ->assertStatus(200)
            ->assertJsonPath('data.user.email', $user->email);

    }

    public function test_login_fails_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'password' => Str::random(),
        ]);

        $response = $this->post(route('login', [
            'email' => $user->email,
            'password' => 'password',
        ]));

        $response
            ->assertStatus(401);
    }
}
