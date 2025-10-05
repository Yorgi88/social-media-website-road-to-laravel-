<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ExampleController extends Controller
{
    public function aboutPage(){
        // return '<h1>About Page</h1><a href="/">Link</a>';

        $myName = 'Moses Akinmade';
        $favoriteAnimals = array('Dog', 'Cats', 'Goose');
        return view('about', ['name'=> $myName,
        'info'=>'online!', 'allAnimal'=>$favoriteAnimals]);
       

    }

    public function status(){
        return '<h1>Status is Online, not offline</h1><a href="/about">Go to about page</a>';
    }

    public function home(){
        return view('homepage');
    }

    public function post(){
        return view('single-post');
    }
}
