<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', [UserController::class, "showCorrectHomepage"])->name('login');
Route::get('/post', [ExampleController::class, "post"]);
Route::post('/register', [UserController::class, "register"])->middleware('guest');
Route::post('/login', [UserController::class, "login"])->middleware('guest');
Route::post('/logout', [UserController::class, "logout"])->middleware('auth');
Route::get('/manage-avatar', [UserController::class, "showAvatarForm"]);
Route::post('/manage-avatar', [UserController::class, "storeAvatar"]);

//you can only log out if you are already an authenticated user that's logged in

Route::get('/create-post', [PostController::class, "showCreatePost"])->middleware('mustBeloggedIn');
Route::post('/create-post', [PostController::class, "storeNewPost"])->middleware('auth');
Route::get('/post/{post}', [PostController::class, "getUserPost"]);

Route::get('/profile/{user:name}', [UserController::class, "userProfile"]);

Route::delete('/post/{post}', [PostController::class, "deletePost"])->middleware('can:delete,post');

Route::get('/post/{post}/edit', [PostController::class, "viewEditForm"])->middleware('can:update,post');
Route::put('/post/{post}', [PostController::class, "saveEdit"])->middleware('can:update,post');
Route::get('/admin-only', function(){
    return '<h2>Only Admins Can view This</h2>';
})->middleware('can:visitAdminPages');

