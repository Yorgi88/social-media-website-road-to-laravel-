<?php

namespace App\Livewire;

use Livewire\Component;
use App\Events\ChatMessage;

class Chat extends Component
{
    public $textvalue = "";
    public $chatLog = array();

    public function getListeners(){
        return [
            "echo-private:chatchannel,ChatMessage" => "notifyNewMessage"
        ];
    }

    public function notifyNewMessage($x){
        //to receive the incoming chat msg
        array_push($this->chatLog, $x['chat']);
    }

    public function send(){
        //we want to make sure only authorized users can send chat
        if (!auth()->check()) {
            # code...
            abort(403, 'Unauthorized');
        }

        if (trim(strip_tags($this->textvalue)) == '') {
            # a user can just hit enter without tyoing anything,, this if block takes care of that
            return;
        }

        //if nothing else, we push the msg into the array
        array_push($this->chatLog, ['selfmessage' => true, 'username' => auth()->user()->name, 'textvalue' => strip_tags($this->textvalue), 'avatar' => auth()->user()->avatar]);
        //if the user is the one that sent the message, the ui will display blue meaning self
        //if its another user in the chat it will be in gray color form

        broadcast(new ChatMessage(['selfmessage' => false, 'username' => auth()->user()->name, 'textvalue' => strip_tags($this->textvalue), 'avatar' => auth()->user()->avatar]))->toOthers();
        $this->textvalue = '';
        //wen a user types a msg and hit enter, the text in the input field should disappear
    }
    public function render()
    {
        return view('livewire.chat'); 
    }
}
