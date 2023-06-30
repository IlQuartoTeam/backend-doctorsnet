<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SpecializationController;
use App\Models\Doctor;

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


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');

Route::resource('specializations', SpecializationController::class)->only(['index']);
Route::resource('doctors', DoctorController::class)->only(['index']);
Route::resource('doctors.reviews', ReviewController::class)->only(['store']);


Route::match(['put', 'patch'], '/user/edit', [DoctorController::class, 'update'])->middleware('auth:sanctum');
