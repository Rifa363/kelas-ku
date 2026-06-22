<?php

namespace App\Providers;

use Illuminate\Foundation\Vite;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite as ViteFacade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $hotFile = public_path('hot');
        if (file_exists($hotFile)) {
            @unlink($hotFile);
        }

        $this->app->singleton(Vite::class, function ($app) {
            return (new Vite($app))->useHotFile('');
        });
    }

    public function boot(): void
    {
        ViteFacade::useHotFile('');

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
