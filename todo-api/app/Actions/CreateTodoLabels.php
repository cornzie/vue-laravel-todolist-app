<?php

namespace App\Actions;

use App\Models\Label;
use Illuminate\Support\Collection;

class CreateTodoLabels extends Action
{
    public function __construct(public array $labels)
    {
        parent::__construct();
    }

    public function execute(): Collection
    {
        $existingLabels = Label::whereIn('name', $this->labels)->get()->keyBy('name');
        $newLabels = array_diff($this->labels, $existingLabels->keys()->toArray());

        $newLabelData = array_map(function ($label) {
            return ['name' => $label];
        }, $newLabels);

        if (! empty($newLabelData)) {
            Label::insert($newLabelData);
        }

        $allLabels = Label::whereIn('name', $this->labels)->get();

        return $allLabels;
    }
}
