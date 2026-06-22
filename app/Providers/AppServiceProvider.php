<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (app()->environment('production')) {
            $hotFile = public_path('hot');
            if (file_exists($hotFile)) {
                @unlink($hotFile);
            }

            Vite::useHotFile(null);

            URL::forceScheme('https');
        }
    }
}
