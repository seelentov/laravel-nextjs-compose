<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\LoggingController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::get('test', [TestController::class, 'test'])->name('test');

    Route::group([
        'prefix' => 'auth',
    ], function () {
        Route::group([
            'middleware' => ['api'],
        ], function () {
            Route::post('register', [AuthController::class, 'register'])->name('register');
            Route::post('login', [AuthController::class, 'login'])->name('login');
            Route::post('logout', [AuthController::class, 'logout'])->name('logout');
            Route::post('refresh', [AuthController::class, 'refresh'])->name(name: 'refresh');
            Route::get('me', [AuthController::class, 'me'])->name('me');
        });
    });

    Route::group([
        'prefix' => 'folders',
    ], function () {
        Route::group([
            'middleware' => ['api'],
        ], function () {
            Route::get('', [FolderController::class, 'index']);
            Route::get('{id}', [FolderController::class, 'show']);
            Route::delete('{id}', [FolderController::class, 'remove']);
            Route::post('', [FolderController::class, 'store']);
            Route::patch('{id}', [FolderController::class, 'update']);
        });
    });

    Route::group([
        'prefix' => 'files',
    ], function () {
        Route::group([
            'middleware' => ['api'],
        ], function () {
            Route::get('{id}', [FileController::class, 'show']);
            Route::delete('{id}', [FileController::class, 'remove']);
            Route::post('', [FileController::class, 'store']);
            Route::patch('{id}', [FileController::class, 'update']);
        });
    });
});
