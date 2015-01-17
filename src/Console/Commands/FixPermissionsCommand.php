<?php

namespace CachetHQ\Cachet\Console\Commands;

use DirectoryIterator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class FixPermissionsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'cachet:chmod';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fixes file permissions.';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function fire()
    {
        $this->recursiveChmod(app_path('storage').'/');

        $database = Config::get('database.default');

        if ($database === 'sqlite') {
            chmod(app_path('database').'/', 755);
            chmod(Config::get('database.sqlite.database'), 755);
        }
    }

    /**
     * Recursively sets a paths file permissions.
     *
     * @param  string $path
     * @param  string $mode
     *
     * @return void
     */
    protected function recursiveChmod($path, $mode = '0755')
    {
        $dir = new DirectoryIterator($path);
        foreach ($dir as $item) {
            if (!$item->isDot()) {
                chmod($item->getPathname(), $mode);
            }

            if ($item->isDir() && !$item->isDot()) {
                $this->recursiveChmod($item->getPathname());
            }
        }
    }
}
