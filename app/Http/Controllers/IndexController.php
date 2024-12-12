<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller{
    /** index */
    public function index(Request $request){
        return view("frontend.index");
    }
    /** index */
}
