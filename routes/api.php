<?php

use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('task')->controller(TaskController::class)->group(function(){
    Route::post('/', 'create');
    Route::get('/', 'index');
    Route::get('/{task}', 'show');
    Route::put('/{task}', 'update');
    Route::delete('/{task}', 'destroy');
    //testes
});

// Route::post('/subtask', [SubtaskController::class, 'create']);

Route::prefix('subtask')->controller(SubtaskController::class)->group(function(){
    Route::post('/', 'create');
    Route::put('/{subtask}', 'update');
    Route::delete('/{subtask}', 'destroy');
});