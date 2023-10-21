<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TodolistController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('profile.todo'));
});

Route::middleware('auth')->group(function () {
    Route::get('/users', [ProfileController::class, 'index'])->name('users.index');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/todo', [ProfileController::class, 'getTodoList'])->name('profile.todo');
    
    Route::get('/todo/{todolist}/tasks', [TodolistController::class, 'getTasks'])->name('todo.tasks');
    Route::post('/todo', [TodolistController::class, 'store'])->name('todo.store');
    Route::delete('/todo/{todo}', [TodolistController::class, 'destroy'])->name('todo.destroy');
    
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::post('/tasks/{task}/share', [TaskController::class, 'share'])->name('tasks.share');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    
    Route::post('/steps', [StepController::class, 'store'])->name('steps.store');
});

require __DIR__.'/auth.php';
