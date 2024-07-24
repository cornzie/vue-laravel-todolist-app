<?php

namespace App\Http\Requests;

use App\Enums\TodoPriority;
use App\Enums\TodoStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreTodoRequest extends FormRequest
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
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['nullable', 'string', 'min:3'],
            'status' => ['nullable', 'string', Rule::enum(TodoStatus::class)],
            'priority' => ['nullable', 'string', Rule::enum(TodoPriority::class)],
            'due_at' => ['nullable', 'date_format:format,Y-m-d H:i:s'],

            'labels' => ['nullable', 'array'],
            'labels.*' => ['distinct', 'string'],

            'tasks' => 'nullable|array',
            'tasks.*.title' => 'required|string|max:255',
            'tasks.*.description' => 'nullable|string',
            'tasks.*.status' => ['required', Rule::enum(TodoStatus::class)],

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'tasks.*.title.required' => 'Your sub tasks must have a title',
            'tasks.*.status.required' => 'Your sub tasks does not seem to have a status',
        ];
    }
}
