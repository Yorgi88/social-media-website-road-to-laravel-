<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function followUser(User $user){
        //u cannot follow yourself, 
        if ($user->id == auth()->user()->id) {
            # code...
            return back()->with('error', 'you cannot follow yourself');
        }
        //u cannot follow someone you're already following
        $existCheck = Follow::where([['user_id', '=', auth()->user()->id], ['followeduser', '=', $user->id]])->count();
        if ($existCheck) {
            # code...
            return back()->with('error', 'you are already following this user');
            
        }
        $newFollow = new Follow();
        $newFollow->user_id = auth()->user()->id;
        $newFollow->followeduser = $user->id;
        $newFollow->save();
        return '<h2>Followed</h2>';
    }

    public function unFollowUser(){
        
    }
}
