<?php

namespace App\Models;

use App\Enums\TodoStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'todo_id',
        'title',
        'description',
        'status',
    ];

    protected function casts()
    {
        return [
            'status' => TodoStatus::class,
        ];
    }

    public function todo()
    {
        return $this->belongsTo(Todo::class);
    }
}
