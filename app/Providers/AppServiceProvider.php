<?php

namespace App\Providers;

use App\Vite;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite as ViteFacade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(\Illuminate\Foundation\Vite::class, fn ($app) => new Vite($app));
        $this->app->singleton(Vite::class, fn ($app) => new Vite($app));
    }

    public function boot(): void
    {
        Blade::directive('vite', function ($expression) {
            $expression = $expression ?: '()';
            return "<?php echo app('App\\\\Vite'){$expression}; ?>";
        });

        ViteFacade::useHotFile(storage_path('framework/cache/.no-vite-hot'));

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
