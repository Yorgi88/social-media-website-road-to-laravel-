<?php

namespace App\Livewire;

use Livewire\Component;

class Deletepost extends Component
{
    public $post;

    public function delete(){
        //check if the user is authorized to delete
        $this->authorize('delete', $this->post);
        $this->post->delete();

        session()->flash('success', 'post deleted');
        return $this->redirect('/profile/' . auth()->user()->name, navigate:true);
    }
    
    public function render()
    {
        return view('livewire.deletepost');
    }
}
