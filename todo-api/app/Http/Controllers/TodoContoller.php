<?php

namespace App\Http\Controllers;

use App\Actions\CreateNewTodo;
use App\Actions\UpdateTodo;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Resources\TodoResource;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;

class TodoContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return ApiResponse::ok(['todo_list' => TodoResource::collection($request->user()->todos()->latest()->get())]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoRequest $request)
    {
        $request->validated();

        $todo = (new CreateNewTodo(
            $request->title,
            $request->description,
            $request->status,
            $request->priority,
            $request->due_at,
            $request->labels,
            $request->tasks,
        ))->execute();

        return ApiResponse::created(['todo' => new TodoResource($todo)]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string|int $todo)
    {
        $todo = $request->user()->todos()->where('id', $todo)->first();

        return is_null($todo) ? ApiResponse::notFound('Todo not found') : ApiResponse::ok([
            'todo' => $todo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoRequest $request, string|int $todo)
    {
        $validated = $request->validated();

        $todo = $request->user()->todos()->find($todo);

        if (! $todo) {
            return ApiResponse::notFound('Todo not found');
        }

        $todo = (new UpdateTodo($todo, $validated))->execute();

        return ApiResponse::ok(['todo' => $todo]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string|int $todo)
    {
        $todo = $request->user()->todos()->find($todo);

        if (! $todo) {
            return ApiResponse::notFound('Todo not found');
        }

        $todo->delete();

        return ApiResponse::noContent();
    }
}
