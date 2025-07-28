<?php

use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(TodoController::class)->prefix('todo')->group(function () {
    Route::get('/', 'index')->name('todo.index');
    Route::post('/', 'store')->name('todo.store');
    Route::put('/{todo}', 'complete')->name('todo.complete');
    Route::delete('/{toDo}', 'destroy')->name('todo.destroy');
    
    // soft deletes (extra routes)
    Route::get('/deleted', 'getDeletedTodos')->name('todo.getDeletedTodos');
    Route::get('/all', 'getAllTodos')->name('todo.getAllTodos');
    Route::put('/{id}/restore', 'restore')->name(name: 'todo.restore');
    Route::delete('/{id}/delete-permanently', 'forceDelete')->name('todo.forceDelete');

});
