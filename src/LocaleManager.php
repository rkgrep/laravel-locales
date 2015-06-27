<?php

namespace rkgrep\Locales;

use Illuminate\Support\Manager;
use Illuminate\Contracts\Events\Dispatcher;
use rkgrep\Locales\Drivers\ConfigLocaleDriver;
use rkgrep\Locales\Drivers\DatabaseLocaleDriver;
use rkgrep\Locales\Drivers\EloquentLocaleDriver;

class LocaleManager extends Manager
{
    /**
     * Create a new manager instance.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     */
    public function __construct($app, Dispatcher $events = null)
    {
        $this->app = $app;

        if ($events) {
            $events->listen('locale.changed', function() {
                $this->flushActive();
            });
        }
    }

    /**
     * Current active locale
     *
     * @var \rkgrep\Locales\Contracts\Locale|null
     */
    protected $active = null;

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['locales.driver'];
    }

    /**
     * Create config driver
     *
     * @return ConfigLocaleDriver
     */
    public function createConfigDriver()
    {
        return new ConfigLocaleDriver($this->app['config']);
    }

    /**
     * Create database driver
     *
     * @return DatabaseLocaleDriver
     */
    public function createDatabaseDriver()
    {
        $connection = $this->app['db']->connection();
        $table = $this->app['config']['locales.table'];

        return new DatabaseLocaleDriver($connection, $table);
    }

    /**
     * Create eloquent driver
     *
     * @return EloquentLocaleDriver
     */
    public function createEloquentDriver()
    {
        return new EloquentLocaleDriver($this->app['config']['locales.model']);
    }

    /**
     * Get active locale
     *
     * @return mixed
     */
    public function active()
    {
        if (!is_null($this->active)) {
            return $this->active;
        }

        if ($locale = $this->driver()->retrieveByCode($this->app->getLocale())) {
            return $this->active = $locale;
        }

        return $this->active = $this->driver()->retrieveByCode($this->app['config']['app.fallback_locale']);
    }

    /**
     * Clear lodaed active locale
     */
    public function flushActive()
    {
        $this->active = null;
    }
}