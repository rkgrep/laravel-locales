# Laravel locales

A missing package for locale management.

### Installation

You can install Locales using composer. Only *dev-master * version is currently available.

    composer require rkgrep/locales:dev-master@dev

Enable the service provider in your application config (*app.php*)

    // ...
    
    rkgrep\Locales\LocaleServiceProvider::class
    
    // ...

### Configuration

Basic Locales configuation is located in *locales.php* config file. You can use `artisan vendor:publish` command to copy default config to your app config path.

Locales currently supports 3 ways of storing configured locales: config, database and eloquent.

Set the preferred one to `driver` key.

    // ...
    
    'driver' => 'database',
    
    // ...

#### Config driver

Config driver uses *locales.php* to list available locales. English locale is configured by default.

Each locale should have an unique key defining its main code type used in your app. E. g. an **ISO 639‑1** two-letter code. Other locale codes ay be defined in `locales` array. Human-readable locale names may be defined in `names` array, where `native` and `i18n` are recommended to be always present.

    // ...
    
    'en' => [
	    'locales' => ['en', 'en_US', 'en-US', 'en-us', 'eng', 'English', 1033],
        'names' => [
            'native' => 'English',
            'i18n' => 'English (US)'
        ],
    ],
    'ru' => [
	    'locales' => ['ru', 'ru_RU', 'ru-RU', 'ru-ru', 'rus', 'Russian', 1049],
        'names' => [
            'native' => 'Русский',
            'i18n' => 'Russian'
        ],
    ],
    
    // ...

#### Database driver

Database driver uses a table to store locales and their values.

The table name is configured in *locales.php* in `table` key.

    // ...
    
    'table' => 'locales',
    
    // ...

You can add a base migration to your application with `artisan locales:table` command. It uses configured table name, so you don't need to check it. Note that the command does not dump composer autoloads so you should run `composer dump-autoload` for the migration to work.

The base schema does not use autoincrementable field. Instead it has a *code* column as a primary key.

#### Eloquent driver

Eloquent driver returns a locale model instance so it can be further connected to other models via relations and customized as any other model.

Provide `model` key to your *locales.php* to change the default model class.

    // ...
    
    'model' => \rkgrep\Locales\EloquentLocale::class,
    
    // ...

### Usage

The service provider stores a Manager at `locales` service key in your app. You can get it anywhere by calling `app('locales')` helper.

#### Retrieving active locale

The active locale is resolved frop `getLocale()` method of the application. If the provided key is not available, the manager tries to get a fallback locale.

    $locale = app('locales')->active(); // A Locale contract or null is returned.

You can also use `rkgrep\Locales\Contracts\Locale` typehint to get an active locale via dependency injection

    use rkgrep\Locales\Contracts\Locale;

    // ...

    public function getIndex(Locale $locale)
    {
        // Your controller
    }

#### Retrieving locale by code

Use `retrieveByCode` method to get a locale.

    $english = app('locales')->retrieveByCode('en');

#### Retrieving a list of locales

Use `getList` method to get a lias of codes or names keyed by codes.

    $codes = app('locales')->getList(); // ['en' => 'en', 'ru' => 'ru]
    $native = app('locales')->getList('names.native'); // ['en' => 'English (US)', 'ru' => 'Русский']

#### Using a locale

Every driver returns an `rkgrep\Locales\Contracts\Locale` interface implementation.

# License

Locales package is open-sourced package licensed under the [MIT license](http://opensource.org/licenses/MIT).
