<?php

namespace App\Actions;

use App\Models\Todo;

class CreateTodoTasks extends Action
{
    public function __construct(public Todo $todo, public array $tasks)
    {
        parent::__construct();
    }

    public function execute(): mixed
    {
        foreach ($this->tasks as $task) {
            $this->todo->tasks()->updateOrCreate($task);
        }

        return $this->todo;
    }
}
