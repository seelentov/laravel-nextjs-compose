<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Controller
{
    public function index(Request $request)
    {
        dd($request);
        return "laravel";
    }
}
