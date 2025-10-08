<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ExampleController extends Controller
{
    
    public function home(){
        return view('homepage');
    }

    public function post(){
        return view('single-post');
    }
}
