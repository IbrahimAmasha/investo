<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\V1\Auth\ResetPasswordController;
use App\Http\Controllers\Api\V1\PostsController;
use App\Http\Controllers\Api\V1\ProfileController;
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

Route::middleware('auth:sanctum')->group(function () {

Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('profile',[ProfileController::class,'myProfile']);
Route::post('posts',[PostsController::class,'createPosts']);
Route::get('MyPosts',[PostsController::class,'myPosts']);

});

Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::Post('/forgot-password',[ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.forgot');
Route::Post('/reset-password',[ResetPasswordController::class,'reset'])->name('password.reset');


Route::get('test',[ProfileController::class,'test']);