<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Events\ChatMessage;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FollowController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', [UserController::class, "showCorrectHomepage"])->name('login');
Route::get('/post', [ExampleController::class, "post"]);
Route::post('/register', [UserController::class, "register"])->middleware('guest');
Route::post('/login', [UserController::class, "login"])->middleware('guest');
Route::post('/logout', [UserController::class, "logout"])->middleware('auth');
Route::get('/manage-avatar', [UserController::class, "showAvatarForm"])->middleware('mustBeloggedIn');
Route::post('/manage-avatar', [UserController::class, "storeAvatar"])->middleware('mustBeloggedIn');
//you can only log out if you are already an authenticated user that's logged in

Route::post('/create-follow/{user:name}', [FollowController::class, "followUser"])->middleware('mustBeloggedIn');
Route::post('/remove-follow/{user:name}', [FollowController::class, "unFollowUser"])->middleware('mustBeloggedIn');


Route::get('/create-post', [PostController::class, "showCreatePost"])->middleware('mustBeloggedIn');
Route::post('/create-post', [PostController::class, "storeNewPost"])->middleware('auth');
Route::get('/post/{post}', [PostController::class, "getUserPost"]);
Route::get('/search/{post}', [PostController::class, "search"]);

// Route::get('/view-post/{user:name}', [UserController::class, "viewUserPost"])->middleware('mustBeloggedIn');
//---------------- 000000=-------0000000---------

Route::get('/profile/{user:name}', [UserController::class, "userProfile"]);
Route::get('/profile/{user:name}/followers', [UserController::class, "userFollowers"]);
Route::get('/profile/{user:name}/following', [UserController::class, "userFollowing"]);

//chat route
Route::post('/send-chat-message', function(Request $request){
    $formFields = $request->validate([
        'textvalue' => 'required'
    ]);

    //trim white spaces and strip out tags
    if (!trim(strip_tags($formFields['textvalue']))) {
        # code...
        return response()->noContent();
    }

    //if not, broadcast the user's message to all users, as per live chat
    broadcast(new ChatMessage(['username' => auth()->user()->name, 'textvalue' => strip_tags($request->textvalue), 'avatar' => auth()->user()->avatar]))->toOthers();
    return response()->noContent();
})->middleware('mustBeloggedIn');


Route::delete('/post/{post}', [PostController::class, "deletePost"])->middleware('can:delete,post');

Route::get('/post/{post}/edit', [PostController::class, "viewEditForm"])->middleware('can:update,post');
Route::put('/post/{post}', [PostController::class, "saveEdit"])->middleware('can:update,post');
Route::get('/admin-only', function(){
    return '<h2>Only Admins Can view This</h2>';
})->middleware('can:visitAdminPages');

