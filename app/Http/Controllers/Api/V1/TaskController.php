<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreTaskRequest;
use App\Http\Requests\V1\UpdateTaskRequest;
use App\Http\Resources\V1\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //return Task::all();
        return TaskResource::collection($request->user()->tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        // validate new task
        $data = $request->validated();

        if ($data == null) {
            return response()->json([
                'message' => 'No content available'
            ], 204 );
        }

        // user() - Get the user making the request.
        $task = $request->user()->tasks()->create($data);

        // created response
        return response()->json(
            new TaskResource($task),
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'message' => 'Task not found', 
            ], 404); // Http 404 not found
        }
        
        return response()->json(
            new TaskResource($task), 
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $id)
    {

        $task = Task::find($id);

        if (!$task) 
        {
            return response()->json([
                'message' => 'Task id not found'
            ], 404);
        }

        $task->update($request->only([
            'title',
            'description',
            'status'
        ]));

        return response()->json(
            new TaskResource( $task),
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'message'=> 'Task id not found',
            ],  404);
        }
        
        // delete the model in the database
        $task->delete();

        return response()->json([
            'message' => 'Task deleted',
            new TaskResource($task) 
        ], 204); // Http 204 - no content
    }
}
