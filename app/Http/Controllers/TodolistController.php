<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Todolist;
use App\Models\User;
use App\Models\UserTask;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class TodolistController extends Controller
{

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
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'Nullable|string|max:255',
        ]);

        $todolist = Todolist::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        return to_route('profile.todo');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todolist $todo): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        $todo->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return to_route('profile.todo')->with('message', [
            'type' => 'success',
            'text' => 'Updated successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todolist $todo): RedirectResponse
    {
        $tasks = Task::where('todolist_id', $todo->id)->get();

        foreach ($tasks as $task) {
            UserTask::where('task_id', $task->id)->delete();
            
            // TODO (optional) - Warn if there's shared tasks
            // $sharedusers = $task->sharedUsers()->get()->pluck('id');
            // if($sharedusers->count() > 0) {
            //     return to_route('profile.todo')
            //         ->with('message', ['type' => 'error', 'text' => "There's shared tasks"]);
            // };
        }

        $todo->delete();

        return to_route('profile.todo')->with('message', [
            'type' => 'success',
            'text' => 'Deleted'
        ]);
    }

    public function getTasks(Todolist $todolist): Response
    {
        $tasks = $todolist->tasks()
            ->with('steps')
            ->with('sharedUsers')
            ->orderByDesc('created_at')
            ->get();
        $sharedTasks = Auth::user()
            ->sharedTasks()
            ->with('steps')
            ->orderByDesc('created_at')
            ->get();

        return Inertia::render("Tasks/List", [
            'todoId' => $todolist->id,
            'tasks' => $tasks,
            'sharedTasks' => $sharedTasks
        ]);
    }
}
