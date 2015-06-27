<?php

namespace rkgrep\Locales;

use Illuminate\Support\ServiceProvider;

class LocalesServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // merge default config
        $this->mergeConfigFrom(
            __DIR__.'/../config/locales.php',
            'locales'
        );

        $this->app->singleton('locales', function($app) {
            return new LocaleManager($app);
        });

        $this->app->singleton('locales.driver', function ($app) {
            return $app['locales']->driver();
        });

        $this->app->bind(Contracts\Locale::class, function ($app) {
            return $app['locales']->active();
        });

        // Register a separate console commands provider as deferred
        $this->app->registerDeferredProvider(ConsoleServiceProvider::class);
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(array(
            __DIR__.'/../config/locales.php' => config_path('locales.php')
        ));
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'locales',
            'locales.driver',
            'rkgrep\Locales\Contracts\Locale',
        ];
    }
}
