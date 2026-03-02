<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ExternalApi\HttpClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind HttpClient as a singleton so the same instance is used throughout the request
        $this->app->singleton(HttpClient::class, function ($app) {
            return new HttpClient();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // other boot logic (e.g. Blade directives) can stay here
    }
}
?>
