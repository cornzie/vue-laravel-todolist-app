<?php

namespace Tests\Feature\Controllers;

use App\Enums\TodoPriority;
use App\Enums\TodoStatus;
use App\Models\Task;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     */
    public function test_it_fetches_all_todos(): void
    {
        $this->actingAs(User::factory()->has(Todo::factory()->count(3))->create());

        $response = $this->get(route('todos.index'));

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     */
    public function test_it_stores_todos(): void
    {
        $this->actingAs(User::factory()->has(Todo::factory()->count(3))->create());

        $response = $this->post(route('todos.store'), [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(TodoStatus::cases())->value,
            'priority' => $this->faker->randomElement(TodoPriority::cases())->value,
            'due_at' => now()->addDays(2)->format('Y-m-d H:i:s'),
            'labels' => [$this->faker->word(), $this->faker->word(), $this->faker->word()],
            'tasks' => [
                [
                    'title' => $this->faker->sentence(3),
                    'description' => $this->faker->sentence(),
                    'status' => $this->faker->randomElement(TodoStatus::cases())->value,
                ],
                [
                    'title' => $this->faker->sentence(3),
                    'description' => $this->faker->sentence(),
                    'status' => $this->faker->randomElement(TodoStatus::cases())->value,
                ],
            ],
        ]);

        $response->assertStatus(201);
    }

    /**
     * A basic feature test example.
     */
    public function test_it_fetches_one_todos(): void
    {
        $user = User::factory()->has(Todo::factory()->count(3))->create();
        $this->actingAs($user);

        $response = $this->get(route('todos.show', $this->faker->randomElement($user->todos->pluck('id')->toArray())));

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     */
    public function test_it_updates_todos(): void
    {
        $user = User::factory()->has(Todo::factory()->count(1))->create();

        $todo = $user->todos->first();

        $task1 = Task::factory()->create(['todo_id' => $todo->id]);
        $task2 = Task::factory()->create(['todo_id' => $todo->id]);

        $data = [
            'title' => 'Updated Todo Title',
            'description' => 'Updated Description',
            'status' => 'completed',
            'priority' => 'medium',
            'due_at' => now()->addDays(10)->format('Y-m-d H:i:s'),
            'labels' => ['label1'],
            'tasks' => [
                [
                    'title' => 'Updated Task 1 Title',
                    'description' => 'Updated Task 1 Description',
                    'status' => 'completed',
                ],
                [
                    'title' => 'Updated Task 2 Title',
                    'description' => 'Updated Task 2 Description',
                    'status' => 'pending',
                ],
            ],
        ];

        $this->actingAs($user);

        $response = $this->put(route('todos.update', ['todo' => $todo->id]), $data);

        // Assert the response status
        $response->assertStatus(200);

        // Assert the database has the updated data
        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'title' => 'Updated Todo Title',
            'description' => 'Updated Description',
            'status' => 'completed',
            'priority' => 'medium',
            'due_at' => now()->addDays(10)->format('Y-m-d H:i:s'),
        ]);

        foreach ($data['tasks'] as $taskData) {
            $this->assertDatabaseHas('tasks', [
                'title' => $taskData['title'],
                'description' => $taskData['description'],
                'status' => $taskData['status'],
                'todo_id' => $todo->id,
            ]);
        }

        foreach ($data['labels'] as $labelName) {
            $this->assertDatabaseHas('labels', [
                'name' => $labelName,
            ]);
        }

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     */
    public function test_it_deletes_todos(): void
    {
        $user = User::factory()->has(Todo::factory()->count(1))->create();
        $this->actingAs($user);

        $todo = $user->todos->first();

        $response = $this->delete(route('todos.destroy', $todo->id));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('todos', [
            'id' => $todo->id,
        ]);
    }
}
