<?php

namespace rkgrep\Locales;

use rkgrep\Locales\Contracts\Locale;
use Illuminate\Contracts\Support\Arrayable;

class GenericLocale implements Locale
{
    use LocaleTrait;

    /**
     * Locale main code.
     *
     * @var string
     */
    protected $code;

    /**
     * List of locale indexes.
     *
     * @var array
     */
    protected $locales;

    /**
     * List of locale readable names.
     *
     * @var array
     */
    protected $names;

    /**
     * @param $code
     * @param array $locales
     * @param array $names
     */
    public function __construct($code, array $locales = [], array $names = [])
    {
        $this->code = $code;
        $this->locales = $locales;
        $this->names = $names;
    }

    /**
     * @param array $locale
     * @return GenericLocale
     */
    public static function make(array $locale)
    {
        if (!array_key_exists('code', $locale)) {
            throw new \InvalidArgumentException('Undefined code');
        }

        $locales = array_get($locale, 'locales');

        if ($locales instanceof Arrayable) {
            $locales = $locales->toArray();
        }

        $names = array_get($locale, 'names');

        if ($names instanceof Arrayable) {
            $names = $locales->toArray();
        }

        return new static($locale['code'], (array) $locales, (array) $names);
    }
}