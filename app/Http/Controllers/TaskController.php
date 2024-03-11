<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\StoreTaskRequets;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class TaskController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $tasks = Task::all();
        } catch (Throwable $th) {
            Log::info($th);
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'tasks' => TaskResource::collection($tasks),
        ]);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        try {
            Task::create($request->validated());
        } catch (Throwable $th) {
            Log::info($th);
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Task created successfully'
        ], 201);
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        try {
            $task->update($request->validated());
        } catch (Throwable $th) {
            Log::info($th);
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully',
        ]);
    }

    public function destroy(Task $task): JsonResponse
    {
        try {
            $task->delete();
        } catch (Throwable $th) {
            Log::info($th);
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully',
        ]);
    }
}
