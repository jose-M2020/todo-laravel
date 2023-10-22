<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\UserTask;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
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

    public function share(Request $request): RedirectResponse
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        $task->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return to_route('todo.tasks', $task->todolist_id)->with('message', [
            'type' => 'success',
            'text' => 'Updated successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): RedirectResponse
    {
        // TODO: search why does UserTask items cannot be deleted, even if has onDelete('cascade')
        UserTask::where('task_id', $task->id)->delete();
        $task->delete();

        return to_route('todo.tasks', $task->todolist_id)->with('message', [
            'type' => 'success',
            'text' => 'Deleted'
        ]);
    }
}
