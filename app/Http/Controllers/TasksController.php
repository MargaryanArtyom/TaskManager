<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Models\Task;
use App\Models\UserTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        return $user->tasks;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTaskRequest $request)
    {
        $validatedData = $request->validated();
        $user = Auth::user();

        $task = Task::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'order_id' => 1,
        ]);

        UserTask::create([
            'user_id' => $user->id,
            'task_id' => $task->id,
        ]);

        return response()->json(['data' => $task, 'status' => true, 'message' => 'Task Created Successfully'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateTaskRequest $request, $id)
    {
        $validatedData = $request->validated();

        $task = Task::findOrFail($id);

        $task->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
        ]);

        return response()->json(['data' => $task, 'status' => true, 'message' => 'Task Updated Successfully'], 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(['data' => null, 'status' => true, 'message' => 'Task Deleted Successfully'], 200);
    }

    /**
     * @param CreateTaskRequest $request
     * @return mixed
     */
    public function changeOrder(Request $request)
    {
        $task = Task::findOrFail($request->input('task_id'));

        $task->update([
            'order_id' => $request->input('order_id'),
        ]);

        return $task;
    }
}
