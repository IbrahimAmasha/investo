<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\CommentController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\SessionController;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\NotificationController;
use App\Http\Controllers\Api\V1\UserRelationshipController;
use App\Http\Controllers\Api\V1\Auth\ResetPasswordController;
use App\Http\Controllers\Api\V1\Auth\ForgotPasswordController;



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
    Route::get('profile/{id}', [ProfileController::class, 'myProfile']);

    //posts
    Route::apiResource('posts', PostController::class);
    Route::post('posts/like/{id}', [PostController::class, 'like']);
    Route::post('posts/unlike/{id}', [PostController::class, 'unlike']);
    Route::get('posts/likedByUsers/{id}', [PostController::class, 'postLikedBy']);
    Route::get('posts/userPosts/{id}', [PostController::class, 'userPosts']);
    Route::get('posts/followeesPosts/{id}', [PostController::class, 'followeesPosts']);

    //comments
    Route::apiResource('comments', CommentController::class);
    Route::get('comments/postComments/{post_id}', [CommentController::class, 'postComments']);
    Route::post('comments/likeComment/{id}', [CommentController::class, 'likeComment']);

    //session: 
    Route::post('sessions', [SessionController::class, 'bookSession']);
    Route::get('sessions/mentorPendingSessions/{id}', [SessionController::class, 'mentorPendingSessions']);
    Route::get('sessions/acceptSession/{id}', [SessionController::class, 'acceptSession']);
    Route::get('sessions/declineSession/{id}', [SessionController::class, 'declineSession']);

    //follow : 
    Route::post('follow/{id}', [UserRelationshipController::class, 'follow']);
    Route::post('unfollow/{id}', [UserRelationshipController::class, 'unfollow']);
    Route::get('userFollowees/{id}', [UserRelationshipController::class, 'userFollowees']);
    Route::get('userFollowers/{id}', [UserRelationshipController::class, 'userFollowers']);

    // notifications : 
    Route::get('notifications/userNotifications/{id}', [NotificationController::class, 'userNotifications']);
});

Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::Post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.forgot');
Route::Post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.reset');
