<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Follow;

class Unfollow extends Component
{
    public $name;
    

    public function unfollow(){
        //check if user is authd
        if (!auth()->check()) {
            # code...
            abort(403, 'Not Authorized');
        }
        $user = User::where('name', $this->name)->first();
        Follow::where([['user_id', '=', auth()->user()->id], ['followeduser', '=' , $user->id]])->delete();
        session()->flash('success', 'You unfollowed this user');
        return $this->redirect("/profile/{$this->name}", navigate:true);
    }

    public function render()
    {
        return view('livewire.unfollow');
    }
}
