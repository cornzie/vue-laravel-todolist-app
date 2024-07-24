<?php

namespace Tests\Feature\Actions;

use App\Actions\CreateNewUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class CreateNewUserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     */
    public function test_it_creates_new_user(): void
    {
        $user = (new CreateNewUser($this->faker->name(), $this->faker->safeEmail(), Str::random(8)))->execute();

        $this->assertTrue($user instanceof User);
    }
}
