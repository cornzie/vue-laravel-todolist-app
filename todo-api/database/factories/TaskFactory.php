<?php

namespace Database\Factories;

use App\Enums\TodoStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
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
        ];
    }

    public function withTodo(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'todo_id' => Todo::factory()->create()->id,
            ];
        });
    }
}
