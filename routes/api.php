<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\MessageController;
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

Route::get('/doctors/premium/', [DoctorController::class, 'premiumDoctors']);
Route::resource('doctors.messages', MessageController::class)->only(['store']);
Route::resource('doctors.messages', MessageController::class)->only(['destroy'])->middleware('auth:sanctum');
Route::post('/doctors/messages/read', [MessageController::class, 'read'])->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
Route::resource('specializations', SpecializationController::class)->only(['index']);
Route::resource('doctors', DoctorController::class)->parameters(['doctors' => 'doctor:slug'])->only(['index', 'show']);
Route::resource('doctors.reviews', ReviewController::class)->only(['store', 'index']);
Route::match(['put', 'patch'], '/user/edit', [DoctorController::class, 'update'])->middleware('auth:sanctum');
Route::patch('/user/password', [DoctorController::class, 'changePassword'])->middleware('auth:sanctum');
Route::post('/user/image', [DoctorController::class, 'uploadProfile'])->middleware('auth:sanctum');
Route::post('/user/experiences', [DoctorController::class, 'addExperience'])->middleware('auth:sanctum');
Route::post('/user/experiences/{experience}/delete', [ExperienceController::class, 'destroy'])->middleware('auth:sanctum');
Route::post('/user/examinations', [DoctorController::class, 'editExaminations'])->middleware('auth:sanctum');


