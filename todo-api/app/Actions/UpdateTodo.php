<?php

namespace App\Actions;

use App\Models\Todo;
use Illuminate\Support\Arr;

class UpdateTodo extends Action
{
    public function __construct(public Todo $todo, public array $data)
    {
        parent::__construct();
    }

    public function execute(): mixed
    {
        foreach (Arr::only($this->data, ['title', 'description', 'status', 'priority', 'due_at']) as $key => $value) {
            $this->todo->$key = $value;
        }

        $this->todo->save();

        if (isset($this->data['labels']) && ! empty($this->data['labels'])) {
            $labels = (new CreateTodoLabels($this->data['labels']))->execute();
            (new LabelTodo($this->todo, $labels))->execute();
        }

        if (isset($this->data['tasks']) && ! empty($this->data['tasks'])) {
            (new CreateTodoTasks($this->todo, $this->data['tasks']))->execute();
        }

        return $this->todo;
    }
}
