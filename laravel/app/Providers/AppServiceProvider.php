<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            Services\FileService\IFileService::class,
            Services\FileService\FileService::class
        );

        $this->app->bind(
            Services\FolderService\IFolderService::class,
            Services\FolderService\FolderService::class
        );

        $this->app->bind(
            Services\UserService\IUserService::class,
            Services\UserService\UserService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
