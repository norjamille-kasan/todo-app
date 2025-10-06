<?php

use App\Http\Controllers\User\TodoController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
      if(auth()->user()->role === 'admin'){
        return redirect('/admin/dashboard');
       }else{
         return redirect('/user/dashboard');
      }
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware(['auth', 'verified','userOnly'])->group(function () {
     Route::get('/user/dashboard', function () {
            return Inertia::render('user/Dashboard');
     });

     Route::get('/user/todos', [TodoController::class, 'index']);
     Route::get('/user/todos/create', [TodoController::class, 'create']);
     Route::post('/user/todos', [TodoController::class, 'store']);
     Route::get('/user/todos/{todo}/edit', [TodoController::class, 'edit']);
     Route::put('/user/todos/{todo}', [TodoController::class, 'update']);
     Route::delete('/user/todos/{todo}', [TodoController::class, 'destroy']);
});



Route::middleware(['auth', 'verified','adminOnly'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index']);
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
