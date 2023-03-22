<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TasksController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/dashboard', [TasksController::class, 'index']);
Route::get('/', [TasksController::class, 'index']);

Route::group(['middleware' => ['auth']], function () {
   Route::resource('tasks', TasksController::class);
   Route::resource('tasks', TasksController::class, ['only' => ['edit', 'destroy']]);
   

});

require __DIR__.'/auth.php';
