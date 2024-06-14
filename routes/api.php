<?php

use App\Http\Controllers\Admin\CoursesIntegrationController;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\V1\Auth\ResetPasswordController;
use App\Http\Controllers\Api\V1\CommentController;
use App\Http\Controllers\Api\V1\model_ai\PredictionController;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\SessionController;
use App\Http\Controllers\Api\V1\UserRelationshipController;
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
    Route::get('profile', [ProfileController::class, 'myProfile']);

    //posts
    Route::apiResource('posts', PostController::class);
    Route::post('posts/like/{id}', [PostController::class, 'like']);
    Route::post('posts/unlike/{id}', [PostController::class, 'unlike']);
    Route::get('posts/likedByUsers/{id}', [PostController::class, 'postLikedBy']);

    //comments
    Route::apiResource('comments', CommentController::class);
    Route::get('comments/postComments/{post_id}', [CommentController::class,'postComments']);

    //session: 
    Route::post('sessions',[SessionController::class,'bookSession']);

    //follow : 
    Route::post('follow/{id}',[UserRelationshipController::class,'follow']);
    Route::post('unfollow/{id}',[UserRelationshipController::class,'unfollow']);
    Route::get('userFollowees/{id}',[UserRelationshipController::class,'userFollowees']);
    Route::get('userFollowers/{id}',[UserRelationshipController::class,'userFollowers']);

    Route::post('predict',[PredictionController::class,'predict']);

 //model Ai 

});

Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::Post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.forgot');
Route::Post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.reset');


Route::get('test', [ProfileController::class, 'test']);


//integration python Courses

Route::get('getCourses',[CoursesIntegrationController::class, 'getCourses']);
Route::post('create',[CoursesIntegrationController::class, 'create']);
