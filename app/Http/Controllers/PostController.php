<?php

namespace App\Http\Controllers;

use \App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function showCreatePost(){
        return view('create-post');
    }

    public function storeNewPost(Request $request){
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        // we want to strip out any html tag an attacker might take advantage of
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $incomingFields['user_id'] = auth()->id();  //to get the userid of the poster

        $newPost = Post::create($incomingFields);
        return redirect("/post/{$newPost->id}")->with('success', 'post created successfully');
    }

    public function getUserPost(Post $post){
        // return $post->title;
        return view('single-post', ['post' => $post]);
    }
}
