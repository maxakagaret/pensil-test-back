<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpenseController;
// use App\Http\Controllers\RegisterController;
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

// Route::post('register', 'RegisterController@register');

Route::get('expense', [ExpenseController::class, 'index']);
Route::get('expense/{id}', [ExpenseController::class, 'show']);
Route::post('expense', [ExpenseController::class, 'store']);
Route::patch('expense/{id}', [ExpenseController::class, 'update']);
Route::delete('expense/{id}', [ExpenseController::class, 'delete']);