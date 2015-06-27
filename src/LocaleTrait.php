<?php

namespace rkgrep\Locales;

trait LocaleTrait
{
    /**
     * Get locale main code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get locale codes.
     *
     * @return array
     */
    public function getLocales()
    {
        return (array) $this->locales;
    }

    /**
     * Get list of locale names.
     *
     * @return array
     */
    public function getNames()
    {
        return (array) $this->names;
    }

    /**
     * Determine if locale qualifies provided code.
     *
     * @param  string $locale
     * @return string mixed
     */
    public function is($locale)
    {
        foreach ($this->getLocales() as $acceptable) {
            if (starts_with($acceptable, $locale)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get native locale name.
     *
     * @return mixed
     */
    public function getNativeName()
    {
        return array_get($this->getNames(), 'native');
    }

    /**
     * Get international locale name.
     *
     * @return mixed
     */
    public function getInternationalName()
    {
        return array_get($this->getNames(), 'i18n');
    }

    /**
     * Determine if the locale is system default.
     *
     * @return bool
     */
    public function isDefault()
    {
        return $this->getCode() == app()->getLocale();
    }

    /**
     * Determine if the locale is fallback.
     *
     * @return bool
     */
    public function isFallback()
    {
        return $this->getCode() == app('config')->get('app.fallback_locale');
    }
}