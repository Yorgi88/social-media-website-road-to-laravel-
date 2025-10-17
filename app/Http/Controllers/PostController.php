<?php

namespace App\Http\Controllers;

use \App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        $post['body'] = Str::markdown($post->body);
        return view('single-post', ['post' => $post]);
    }

    public function deletePost(Post $post){
        $post->delete();
        return redirect('/profile/' . auth()->user()->name)->with('success', 'post deleted');
    }

    public function viewEditForm(Post $post){
        return view('edit-post', ['post' => $post]);
    }

    public function saveEdit(Post $post, Request $request){
        // we need to things, the $post value arg and the incoming request
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $post->update($incomingFields);

        return back()->with('success', 'saved changes');
        // the back just means return the user to the previous route the user was before, 
        // the user was taken to this route
    }

    public function search($post){
        $posts = Post::search($post)->get();
        $posts->load('user:id,name,avatar');
        return $posts;
    }

}
