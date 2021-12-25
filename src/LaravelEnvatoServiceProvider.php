<?php

namespace InfyOmLabs\LaravelEnvato;

use Illuminate\Support\ServiceProvider;
use InfyOmLabs\LaravelEnvato\Client\EnvatoClient;
use InfyOmLabs\LaravelEnvato\Managers\AuthManager;

class LaravelEnvatoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-envato.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-envato');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-envato', function () {
            return new EnvatoAPIManager();
        });

        $this->app->singleton(EnvatoClient::class, function () {
            return new EnvatoClient();
        });

        $this->app->singleton(AuthManager::class, function () {
            return new AuthManager();
        });
    }
}
