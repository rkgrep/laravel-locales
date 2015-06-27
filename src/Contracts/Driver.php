<?php

namespace rkgrep\Locales\Contracts;

interface Driver
{
    /**
     * Retrieve a locale by unique identifier.
     *
     * @param  mixed  $code
     * @return \rkgrep\Locales\Contracts\Locale|null
     */
    public function retrieveByCode($code);

    /**
     * Retrieve list of locale codes or names keyed by codes.
     *
     * @param  name
     * @return mixed
     */
    public function getList($name = null);
}