<?php

namespace rkgrep\Locales\Drivers;

use rkgrep\Locales\Contracts\Driver;
use rkgrep\Locales\GenericLocale;
use Illuminate\Contracts\Config\Repository;

class ConfigLocaleDriver implements Driver
{
    /**
     * The active database connection.
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * Create a new config locale provider.
     *
     * @param  \Illuminate\Contracts\Config\Repository  $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Retrieve a locale by unique identifier.
     *
     * @param  mixed  $code
     * @return \rkgrep\Locales\Contracts\Locale|null
     */
    public function retrieveByCode($code)
    {
        $locale = $this->config->get('locales.list.'.$code);
        $locale['code'] = $code;
        return $this->getGenericLocale($locale);
    }

    /**
     * Get the generic user.
     *
     * @param  mixed  $locale
     * @return \rkgrep\Locales\GenericLocale|null
     */
    protected function getGenericLocale($locale)
    {
        if ($locale !== null) {
            return GenericLocale::make($locale);
        }
    }

    /**
     * Retrieve list of locale codes or names keyed by codes.
     *
     * @param  name
     * @return array
     */
    public function getList($name = null)
    {
        $list = $this->config->get('locales.list', []);
        $codes = array_keys($list);
        if ($name) {
            return array_combine($codes, array_pluck($list, $name));
        }
        else {
            return array_combine($codes, $codes);
        }
    }
}
