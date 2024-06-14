<?php

use App\Http\Controllers\Admin\CoursesIntegrationController;
use App\Http\Controllers\admin\InvestorController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\UserController;



 


 use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('pusher');
// });

Route::get('/', function () {
    return view('admin.home');
});

//users
Route::get('users',[UserController::class, 'index']);
Route::get('predict_history/{id}',[UserController::class, 'History']);

Route::post('block/user/{id}',[UserController::class, 'blockOfUser']);
 
//posts 
Route::get('posts/{status}',[PostsController::class, 'status']);
Route::get('posts',[PostsController::class, 'index']);
Route::post('remove/posts/{id}',[UserController::class, 'RemovePosts']);
Route::get('user/posts/{id}',[PostsController::class, 'index']);
 

Route::get('Statistics-investor',[InvestorController::class, 'index']);

Route::get('getCourses',[CoursesIntegrationController::class, 'getCourses']);
