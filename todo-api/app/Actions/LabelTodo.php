<?php

namespace App\Actions;

use App\Models\Label;
use App\Models\Todo;
use Illuminate\Support\Collection;

class LabelTodo extends Action
{
    public function __construct(public Todo $todo, public Label|Collection $labels)
    {
        parent::__construct();
    }

    public function execute(): mixed
    {
        return $this->todo->labels()->sync($this->labels->pluck('id')->toArray());
    }
}
