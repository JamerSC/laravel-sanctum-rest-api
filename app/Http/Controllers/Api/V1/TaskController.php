<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TaskResoure;
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
        //return $request->user()->tasks;
        return TaskResoure::collection($request->user()->tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate create request
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'status'=> 'in:pending,in-progress,completed',
        ]);

        // user() - Get the user making the request.
        $task = $request->user()->tasks()->create($data);

        // created response
        return response()->json(
            new TaskResoure($task),
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //return $task;
        
        return response()->json(
            new TaskResoure($task), 
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //$this->authorize('update', $task); // optional for ownership check

        $task->update($request->only(['title','description','status']));

        return response()->json(
            new TaskResoure( $task),
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //$this->authorize('delete', $task); //optional
        
        // delete the model in the database
        $task->delete();

        return response()->json([
            'message' => 'Task deleted',
            $task
        ], 200);
    }
}
