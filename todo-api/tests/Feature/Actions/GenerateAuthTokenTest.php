<?php

namespace Tests\Feature\Actions;

use App\Actions\GenerateAuthToken;
use App\Models\User;
use Tests\TestCase;

class GenerateAuthTokenTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $user = User::factory()->create();

        $token = (new GenerateAuthToken($user))->execute();

        $this->assertTrue(is_string($token));
    }
}
