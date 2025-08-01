<?php

namespace App\Providers;

use App\Helpers\Str;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Use the Paginator's Tailwind pagination views
        \Illuminate\Pagination\Paginator::useBootstrapFive();

        // Register Str facade alias
        $this->app->singleton('str', function () {
            return new Str;
        });

        // Add markdown directive to Blade
        Blade::directive('markdown', function ($expression) {
            return "<?php echo \App\Helpers\Str::markdownToHtml($expression); ?>";
        });
    }
}
