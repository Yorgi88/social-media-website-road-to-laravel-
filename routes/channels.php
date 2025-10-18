<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chatchannel', function(){
    //allow any logged in user to have access
    if (auth()->check()) {
        # code...
        return true;
    }
    return false;
});
