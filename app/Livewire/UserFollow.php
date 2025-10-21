<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Follow;


class UserFollow extends Component
{
    public $name;
    
    public function follow() {
        if (!auth()->check()) {
            abort(403, 'Not authorized');
        }
        //we got the code from the FollowController

        $user = User::where('name', $this->name)->first();

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

        session()->flash('success', 'user followed');

        return $this->redirect("/profile/{$this->name}", navigate:true);
    }


    public function render()
    {
        return view('livewire.user-follow');
    }
}
