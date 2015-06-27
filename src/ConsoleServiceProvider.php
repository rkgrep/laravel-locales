<?php

namespace rkgrep\Locales;

use Illuminate\Support\ServiceProvider;
use rkgrep\Locales\Console\TableCommand;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('command.locales.table', function ($app) {
            return new TableCommand($app['files']);
        });

        $this->commands(
            'command.locales.table'
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'command.locales.table'
        ];
    }
}
