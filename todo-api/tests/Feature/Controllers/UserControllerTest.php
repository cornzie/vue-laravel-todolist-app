<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     */
    public function test_it_stores_users_successfully(): void
    {
        $email = $this->faker->safeEmail();
        $name = $this->faker->name();
        $password = Str::random(8);

        $response = $this->post(route('users.store', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]));

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => $email,
            'name' => $name,
        ]);
    }

    /**
     * A basic feature test example.
     */
    #[DataProvider('storeUserData')]
    public function test_it_validates_before_stores_users_successfully($name, $email, $password, $password_confirmation): void
    {
        $response = $this->post(route('users.store', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => Str::random(8),
        ]));

        $response->assertStatus(422);
    }

    public static function storeUserData(): array
    {
        $password = Str::random(8);

        return [
            'no_name' => ['', 'email@example.com', $password, $password],
            'no_email' => ['Mr. Jon Dee', '', $password, $password],
            'no_password' => ['Mr. Jon Dee', 'email@example.com', '', ''],
            'password_confirmation' => ['Mr. Jon Dee', 'email@example.com', $password, Str::random()],
        ];
    }

    public function test_it_returns_a_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('users.show', $user->id))
            ->assertStatus(200)
            ->assertJsonPath('data.user.email', $user->email);
    }
}
