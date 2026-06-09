<?php

namespace App\Providers;

use App\Services\ForwardChainingService;
use Illuminate\Support\ServiceProvider;

class ExpertSystemServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ForwardChainingService::class, function ($app) {
            return new ForwardChainingService();
        });
    }

    public function boot(): void
    {
        //
    }
}