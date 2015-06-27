<?php

namespace rkgrep\Locales\Contracts;

interface Locale
{
    /**
     * Get locale main code.
     *
     * @return string
     */
    public function getCode();

    /**
     * Get locale codes.
     *
     * @return array
     */
    public function getLocales();

    /**
     * Get list of locale names.
     *
     * @return array
     */
    public function getNames();

    /**
     * Determine if locale qualifies provided code.
     *
     * @param  string $locale
     * @return string mixed
     */
    public function is($locale);

    /**
     * Get native locale name.
     *
     * @return mixed
     */
    public function getNativeName();

    /**
     * Get international locale name.
     *
     * @return mixed
     */
    public function getInternationalName();

    /**
     * Determine if the locale is system default.
     *
     * @return bool
     */
    public function isDefault();

    /**
     * Determine if the locale is fallback.
     *
     * @return bool
     */
    public function isFallback();
}
