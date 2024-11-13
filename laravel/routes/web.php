<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\LoggingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "logging", 'middleware' => 'web'], function () {
    Route::post('auth', [LoggingController::class, 'auth'])->name('logging_auth');
    Route::get('auth', [LoggingController::class, 'login'])->name('logging_login');
});

Route::get('storage/{pathToFile}', function ($pathToFile) {
    dd($pathToFile);
});
