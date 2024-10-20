<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class Controller
{
    public function index(Request $request)
    {
        dd(User::all());
        return "laravel";
    }
}
