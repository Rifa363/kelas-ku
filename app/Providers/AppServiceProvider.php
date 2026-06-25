<?php

namespace App\Providers;

use App\Vite;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite as ViteFacade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(\Illuminate\Foundation\Vite::class, function ($app) {
            $vite = new Vite($app);
            $vite->useHotFile(storage_path('framework/cache/.no-vite-hot'));
            return $vite;
        });
    }

    public function boot(): void
    {
        ViteFacade::useHotFile(storage_path('framework/cache/.no-vite-hot'));

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
