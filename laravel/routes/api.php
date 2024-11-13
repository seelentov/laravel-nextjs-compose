<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\LoggingController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::get('', [TestController::class, 'index'])->name('index');
    Route::get('test', [TestController::class, 'test'])->name('test');
});
