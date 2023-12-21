<?php

use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\UserProfile;
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

//public routee
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/forgot-password', [AuthenticationController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthenticationController::class, 'resetPassword']);


//private route
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthenticationController::class, 'logout']);

});

//private route that only "Student" can access to
Route::group(['middleware' => ['auth:sanctum', 'role:1']], function () {

    Route::get('/student/info', [UserProfile::class, 'getUserIndi']);
    Route::get('/student/info/{id}', [UserProfile::class, 'getUser']);
    Route::post('/student/updateInfo', [UserProfile::class, 'updateUser']);


});


//private route that only "Admin" can access to
Route::group(['middleware' => ['auth:sanctum', 'role:2']], function () {

});
