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
        if (app()->environment('production')) {
            $this->app->singleton(Vite::class, function () {
                return (new Vite)->useHotFile('');
            });
        }
    }

    public function boot(): void
    {
        if (app()->environment('production')) {
            $hotFile = public_path('hot');
            if (file_exists($hotFile)) {
                @unlink($hotFile);
            }

            ViteFacade::useHotFile('');

            URL::forceScheme('https');
        }
    }
}
