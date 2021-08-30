<?php

namespace Haode\Elaticsearch;

use Illuminate\Support\ServiceProvider;

class ElaticsearchServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'haode');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'haode');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/elaticsearch.php', 'elaticsearch');

        // Register the service the package provides.
        $this->app->singleton('elaticsearch', function ($app) {
            return new Elaticsearch;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['elaticsearch'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/elaticsearch.php' => config_path('elaticsearch.php'),
        ], 'elaticsearch.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/haode'),
        ], 'elaticsearch.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/haode'),
        ], 'elaticsearch.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/haode'),
        ], 'elaticsearch.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
