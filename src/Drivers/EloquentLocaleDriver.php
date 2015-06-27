<?php

namespace rkgrep\Locales\Drivers;

use rkgrep\Locales\Contracts\Driver;

class EloquentLocaleDriver implements Driver
{
    /**
     * The Eloquent locale model.
     *
     * @var string
     */
    protected $model;

    /**
     * Create a new database locale provider.
     *
     * @param  string  $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Retrieve a locale by unique identifier.
     *
     * @param  mixed  $code
     * @return \rkgrep\Locales\EloquentLocale|null
     */
    public function retrieveByCode($code)
    {
        return $this->createModel()->newQuery()->find($code);
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
                $list = $this->createModel()->get([$column, 'code'])->all();
                return array_pluck($list, $path, 'code');
            }
            return $this->createModel()->lists($name, 'code')->all();
        }
        else {
            $codes = $this->createModel()->lists('code')->all();
            return array_combine($codes, $codes);
        }
    }

    /**
     * Create a new instance of the model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createModel()
    {
        $class = '\\'.ltrim($this->model, '\\');

        return new $class;
    }
}
