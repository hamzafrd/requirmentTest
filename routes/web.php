<?php

use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::resource('users', UserController::class);
Route::resource('todo', TodoController::class);

Route::get('todo/recover/{id}', [TodoController::class, 'recover'])->name('todo.recover');

Route::get('todo/destroyPermanent/{id}', [TodoController::class, 'destroyPermanent'])->name('todo.destroyPermanent');

Route::get('todo/getTodos', [TodoController::class, 'getTodos'])->name('todo.getTodos');
Route::get('todo/getTodosTrashed', [TodoController::class, 'getTodosTrashed'])->name('todo.getTodosTrashed');
