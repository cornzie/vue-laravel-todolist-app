<?php

namespace App\Actions;

class CreateNewTodo extends Action
{
    public function __construct(
        public string $title,
        public ?string $description,
        public ?string $status,
        public ?string $priority,
        public ?string $due_at,
        public ?array $labels,
        public ?array $tasks,
    ) {
        parent::__construct();
    }

    public function execute(): mixed
    {
        $todo = $this->user->todos()->create([
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status ?? 'pending',
            'priority' => $this->priority ?? 'medium',
            'due_at' => $this->due_at ?? now()->addDays(2),
        ]);

        if (isset($this->labels) && ! empty($this->labels)) {
            $labels = (new CreateTodoLabels($this->labels))->execute();
            (new LabelTodo($todo, $labels))->execute();
        }

        if (isset($this->tasks) && ! empty($this->tasks)) {
            (new CreateTodoTasks($todo, $this->tasks))->execute();
        }

        return $todo;
    }
}
