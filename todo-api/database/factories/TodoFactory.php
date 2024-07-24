<?php

namespace Database\Factories;

use App\Enums\TodoPriority;
use App\Enums\TodoStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(TodoStatus::cases())->value,
            'priority' => $this->faker->randomElement(TodoPriority::cases())->value,
            'due_at' => now()->addDays(2),
        ];
    }
}
