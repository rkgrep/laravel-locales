<?php

namespace rkgrep\Locales\Drivers;

use Illuminate\Database\ConnectionInterface;
use rkgrep\Locales\Contracts\Driver;
use rkgrep\Locales\GenericLocale;

class DatabaseLocaleDriver implements Driver
{
    /**
     * The active database connection.
     *
     * @var \Illuminate\Database\ConnectionInterface
     */
    protected $conn;

    /**
     * The table containing the locales.
     *
     * @var string
     */
    protected $table;

    /**
     * Create a new database locale provider.
     *
     * @param  \Illuminate\Database\ConnectionInterface  $conn
     * @param  string  $table
     */
    public function __construct(ConnectionInterface $conn, $table)
    {
        $this->conn = $conn;
        $this->table = $table;
    }

    /**
     * Retrieve a locale by unique identifier.
     *
     * @param  mixed  $code
     * @return \rkgrep\Locales\GenericLocale|null
     */
    public function retrieveByCode($code)
    {
        $locale = $this->conn->table($this->table)->where('code', '=', $code)->first();

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
            return GenericLocale::make((array) $locale);
        }
    }

    /**
     * Retrieve list of locale codes or names keyed by codes.
     *
     * @param  name
     * @return mixed
     */
    public function getList($name = null)
    {
        if ($name) {
            if (strpos($name, '.') !== false) {
                list($column, $path) = explode('.', $name, 1);
                $list = $this->conn->table($this->table)->get([$column, 'code']);
                return array_pluck($list, $path, 'code');
            }
            return $this->conn->table($this->table)->lists($name, 'code');
        }
        else {
            $codes = $this->conn->table($this->table)->lists('code');
            return array_combine($codes, $codes);
        }
    }
}
