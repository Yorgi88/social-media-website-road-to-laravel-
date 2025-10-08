<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', [UserController::class, "showCorrectHomepage"]);
Route::get('/post', [ExampleController::class, "post"]);
Route::get('/about', [ExampleController::class, "aboutPage"]);

Route::get('/status', [ExampleController::class, "status"]);

Route::post('/register', [UserController::class, "register"]);
Route::post('/login', [UserController::class, "login"]);
Route::post('/logout', [UserController::class, "logout"]);