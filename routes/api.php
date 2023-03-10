<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// 127.0.01:8000/api/user
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// register & login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/test', [ProductApiController::class, 'test']);

// middlawere auth:api
// Route::get('/products', [ProductAPIController::class, 'index'])->middleware(['auth:sanctum', 'isAuth']);

// Route::middleware(['auth:sanctum', 'isAuth'])->group(function () {
Route::middleware(['auth:sanctum'])->group(function () {
    // resfull api products
    Route::get('/products', [ProductApiController::class, 'index']);
    Route::post('/products', [ProductApiController::class, 'store']);
    Route::get('/products/{id}', [ProductApiController::class, 'show']);
    Route::put('/products/{id}', [ProductApiController::class, 'update']);
    Route::delete('/products/{id}', [ProductApiController::class, 'destroy']);

    // trash products
    Route::get('/trash', [ProductApiController::class, 'trash']);
    Route::delete('/trash/{id}', [ProductApiController::class, 'deletePermanent']);
    Route::get('/trash/{id}/restore', [ProductApiController::class, 'restore']);
    Route::post('/search', [ProductApiController::class, 'search']);

    // user features
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});
