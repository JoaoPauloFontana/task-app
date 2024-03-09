<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\StoreTaskRequets;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return response()->json([
            'tasks' => TaskResource::collection(Task::all()),
        ]);
    }

    public function store(StoreTaskRequest $request)
    {
        Task::create($request->validated());

        return response()->json([
            'message' => 'Task created successfully'
        ], 201);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return response()->json([
            'message' => 'Task updated successfully',
        ]);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully',
        ]);
    }
}
