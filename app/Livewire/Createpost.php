<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
class Createpost extends Component
{
    public $title;
    public $body;

    public function create() {
        //check if the user is authd
        if (!auth()->check()) {
            # code...
            abort(403, 'Unauthorized');
        }

        $incomingFields = $this->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        // we want to strip out any html tag an attacker might take advantage of
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $incomingFields['user_id'] = auth()->id();  //to get the userid of the poster

        $newPost = Post::create($incomingFields);
        session()->flash('success', 'post created successfully');
        return $this->redirect("/post/{$newPost->id}", navigate:true);
        // return redirect("/post/{$newPost->id}")->with('success', 'post created successfully');
    }
    public function render()
    {
        return view('livewire.createpost');
    }
}
