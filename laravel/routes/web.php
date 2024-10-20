<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('/api', [Controller::class, 'index'])->name('index');;
