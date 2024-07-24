<?php

namespace App\Http\Requests;

use App\Enums\TodoPriority;
use App\Enums\TodoStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateTodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'min:3'],
            'description' => ['sometimes', 'nullable', 'string', 'min:3'],
            'status' => ['sometimes', 'required', 'string', Rule::enum(TodoStatus::class)],
            'priority' => ['sometimes', 'required', 'string', Rule::enum(TodoPriority::class)],
            'due_at' => ['sometimes', 'required', 'date_format:Y-m-d H:i:s'],

            'labels' => 'nullable|array',
            'labels.*' => 'string',

            'tasks' => 'nullable|array',
            'tasks.*.title' => 'nullable|string|max:255',
            'tasks.*.description' => 'nullable|string',
            'tasks.*.status' => ['nullable', Rule::enum(TodoStatus::class)],
        ];
    }

    public function messages()
    {
        return [
            'labels.*.required' => 'Labels must have names',
        ];
    }
}
