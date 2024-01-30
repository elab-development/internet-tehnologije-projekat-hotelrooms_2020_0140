<?php

use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);

Route::get('/hotels', [HotelController::class, 'index']);
Route::get('/hotels/{id}', [HotelController::class, 'show']);

Route::get('/rooms', [RoomController::class, 'index']);
Route::get('/rooms/page', [RoomController::class, 'indexPaginate']);
Route::get('/rooms/{id}', [RoomController::class, 'show']);

Route::post('/register', [AuthorizationController::class, 'register']);
Route::post('/login', [AuthorizationController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });

    Route::resource('/hotels', HotelController::class)
        ->only(['store', 'update', 'destroy']);

    Route::resource('/rooms', RoomController::class)
        ->only(['store', 'update', 'destroy']);

    Route::post('/logout', [AuthorizationController::class, 'logout']);
});
