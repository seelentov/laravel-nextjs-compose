<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\LoggingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::get('', [Controller::class, 'index']);
});
