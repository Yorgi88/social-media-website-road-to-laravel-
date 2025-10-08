<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', [UserController::class, "showCorrectHomepage"]);
Route::get('/post', [ExampleController::class, "post"]);
Route::post('/register', [UserController::class, "register"]);
Route::post('/login', [UserController::class, "login"]);
Route::post('/logout', [UserController::class, "logout"]);

Route::get('/create-post', [PostController::class, "showCreatePost"]);
Route::post('/create-post', [PostController::class, "storeNewPost"]);
Route::get('/post/{post}', [PostController::class, "getUserPost"]);