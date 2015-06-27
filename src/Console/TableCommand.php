<?php

namespace rkgrep\Locales\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class TableCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'locales:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a migration for the locales database table';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new queue job table command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $fullPath = $this->createBaseMigration();

        $table = $this->laravel['config']['locales.table'];

        $stub = str_replace(
            '{{table}}', $table, $this->files->get(__DIR__.'/stubs/locales.stub')
        );

        $this->files->put($fullPath, $stub);

        $this->info('Migration created successfully!');
        $this->info('Don\'t forget to run `composer dump-autoload`');
    }

    /**
     * Create a base migration file for the table.
     *
     * @return string
     */
    protected function createBaseMigration()
    {
        $name = 'create_locales_table';

        $path = $this->laravel->databasePath().'/migrations';

        return $this->laravel['migration.creator']->create($name, $path);
    }
}
