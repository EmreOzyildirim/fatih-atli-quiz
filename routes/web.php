<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

Route::get('/home', [HomeController::class, 'index'])->name('home');
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::get('/', [HomeController::class, 'index']);
Route::get('/index', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);


Route::get('/create-todo-item', [HomeController::class, 'create_todo_item']);
Route::post('/create-todo-item', [HomeController::class, 'create_todo_item_post']);

Route::post('/update-status-todo-items', [HomeController::class, 'update_status_todo_items']);

Route::get('/update-todo-item/{id}', [HomeController::class, 'update_todo_item']);
Route::post('/update-todo-item', [HomeController::class, 'update_todo_item_post']);

Route::get('/delete-todo-item/{id}', [HomeController::class, 'delete_todo_item']);
