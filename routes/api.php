<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\RoleController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//private route
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthenticationController::class, 'logout']);
});

//public route
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);
Route::get('/listallBook', [BookController::class, 'listBooks']);
Route::get('/listarrivalBooks', [BookController::class, 'listArrivalBooks']);
Route::get('/searchBook/{query}', [BookController::class, 'searchBook']);
Route::get('/previewBook/uploads/{bookId}', [BookController::class, 'previewBook']);





//private route that only "Admin" can access to
Route::group(['middleware' => ['auth:sanctum', 'role:1']], function () {
    Route::post('/logout', [AuthenticationController::class, 'logout']);
    Route::post('/admin/uploadBook', [BookController::class, 'uploadBook']);
    Route::post('/admin/change_password', [AuthenticationController::class, 'changePassword']);
    Route::get('/admin/listallBook', [BookController::class, 'listBooks']);
    Route::post('/admin/updateBook/{id}', [BookController::class, 'updateBook']);
    Route::delete('/admin/deleteBook/{id}', [BookController::class, 'deleteBook']);
    Route::get('/admin/searchBook/{query}', [BookController::class, 'searchBook']);
    Route::get('/admin/previewBook/uploads/{bookId}', [BookController::class, 'previewBook']);





});

