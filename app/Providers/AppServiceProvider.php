<?php

namespace App\Providers;

use App\Services\EmailService\EmailService;
use App\Services\EmailService\EmailServiceInterface;
use App\Services\FileUploaderService\FileUploaderService;
use App\Services\FileUploaderService\FileUploaderServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(EmailServiceInterface::class,EmailService::class);
        $this->app->bind(FileUploaderServiceInterface::class,FileUploaderService::class);
    }
}
