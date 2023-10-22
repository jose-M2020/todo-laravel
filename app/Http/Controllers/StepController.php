<?php

namespace App\Http\Controllers;

use App\Models\Step;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StepController extends Controller
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
            'description' => 'required|string|max:255',
            'taskId' => 'required|Integer',
        ]);

        $task = Step::create([
            'name' => $request->name,
            'description' => $request->description,
            'task_id' => $request->taskId,
        ]);

        return to_route('todo.tasks', [ 'todolist'  => $request->todoId]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Step $step): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        $step->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return to_route('todo.tasks', $request->todoId)->with('message', [
            'type' => 'success',
            'text' => 'Updated successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Step $step, Request $request): RedirectResponse
    {
        $step->delete();

        return to_route('todo.tasks', $request->todolist)->with('message', [
            'type' => 'success',
            'text' => 'Deleted'
        ]);
    }
}
