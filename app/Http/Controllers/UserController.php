<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;



class UserController extends Controller
{
    public function register(Request $request){
        $incomingFields = $request->validate([
            'name' => ['required', 'min:3', 'max:20', Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'confirmed']
        ]);
    
        $user = User::create($incomingFields);
        auth()->login($user);
        return redirect('/home')->with('success', 'Account Created!');
    }

    public function login(Request $request){
        $incomingFields = $request->validate([
            'login_name' => 'required',
            'login_password' => 'required'
        ]);
        // note that the login_name, is from the input field in the header.blade file
        if (auth()->attempt(['name' => $incomingFields['login_name'], 'password' => $incomingFields['login_password']])) {
            # code...
            $request->session()->regenerate();
            return redirect('/home')->with('success', 'You are logged in');
        } else {
            # code...
            return redirect('/home')->with('error', 'Failed');
        }
        
    }

    public function showCorrectHomepage(){
        if (auth()->check()) {
            # code...
            return view('homepage_logged');
        } else {
            # code...
            return view('homepage');
        }
        
    }

    public function logout(){
        auth()->logout();
        return redirect('/home')->with('success', 'You are logged out');
    }

    public function userProfile(User $user){
        $getUserPost = $user->posts()->latest()->get();
        $postCount = $user->posts()->count();
        return view('profile-posts', ['name' => $user->name, 'posts' => $getUserPost, 'postCount'=> $postCount, 'avatar' => $user->avatar]);
    }

    public function showAvatarForm(){
        return view('avatar-form');
    }

    public function storeAvatar(Request $request){
        // in the avatar-form, remember in the input field, we added a name 'avatar'
        // so we will use that 
        // $request->file('avatar')->store('user_avatars', 'public'); //the store() signifies where the img will be stored locally
        //check the storage dir -> app dir -> public dir -> you'd see user_avatars dir

        // but that's local, if we want to store the avatars where it will be available persistently,
        // there's a public dir in the laravel project, more in the learn.md file

        $request->validate([
            'avatar' => 'required|image|max:3000'
        ]);
        // $request->file('avatar')->store('user_avatars', 'public'); 
        $user = auth()->user();
        $manager = new ImageManager(new Driver());
        $image = $manager->read($request->file('avatar'));
        // we simply want to read the incoming image from the request

        $fileName = $user->id . '-' . uniqid() . '.jpg';
        $imageData = $image->cover(120, 120)->toJpeg();
        // now to actually resize the img

        Storage::disk('public')->put('user_avatars/' . $fileName, $imageData);
        // we gonna call the storage class and put in the img file, the put
        // will take two args, folder path and file name

        $oldAvatar = $user->avatar;

        $user->avatar = $fileName;
        $user->save();

        if ($oldAvatar != '/fallback-avatar.jpg') {
            # code...
            Storage::disk('public')->delete(str_replace('/storage/', '', $oldAvatar));
        }
        return '<h1>Uploaded!</h1>';
    }
}

