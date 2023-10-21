<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\UserTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'todoId' => 'required|Integer',
        ]);

        $task = Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'todolist_id' => $request->todoId,
        ]);

        return to_route('todo.tasks', ['todolist' => $request->todoId]);
    }

    public function share(Request $request)
    {
        $request->validate([
            'taskId' => 'required|Integer',
            'userId' => 'required|Integer',
        ]);

        $task = UserTask::create([
            'task_id' => $request->taskId,
            'user_id' => $request->userId,
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
