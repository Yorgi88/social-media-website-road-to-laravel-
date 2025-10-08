<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

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
}
// note that the login_name, is from the input field in the header.blade file
