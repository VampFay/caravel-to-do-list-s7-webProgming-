<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

// Redirect root to todos index
Route::get('/', [TodoController::class, 'index'])->name('home');

// Todo management routes
Route::resource('todos', TodoController::class)
    ->only(['index', 'store', 'update', 'destroy'])
    ->parameters(['todos' => 'todo']);

Route::patch('todos/{todo}/toggle', [TodoController::class, 'toggle'])->name('todos.toggle');
Route::post('todos/clear-completed', [TodoController::class, 'clearCompleted'])->name('todos.clearCompleted');
Route::post('todos/mark-all-completed', [TodoController::class, 'markAllCompleted'])->name('todos.markAllCompleted');
Route::post('todos/bulk/clear-completed', [TodoController::class, 'clearCompleted']);
Route::post('todos/bulk/complete-all', [TodoController::class, 'markAllCompleted']);
