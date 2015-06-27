<?php

namespace rkgrep\Locales;

use rkgrep\Locales\Contracts\Locale;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;

class EloquentLocale extends Model implements Locale
{
    use LocaleTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'locales';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'code';

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'names' => 'array',
        'locales' => 'array',
    ];

    /**
     * Get only default locale.
     *
     * @param Builder $query
     */
    public function scopeDefault(Builder $query)
    {
        $query->where('code', '=', app()->getLocale());
    }

    /**
     * Get only fallback locale.
     *
     * @param Builder $query
     */
    public function scopeFallback(Builder $query)
    {
        $query->where('fallback', '=', app('config')->get('app.fallback_locale'));
    }
}
