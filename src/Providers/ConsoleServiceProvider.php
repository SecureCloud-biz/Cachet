<?php

namespace CachetHQ\Cachet\Providers;

use CachetHQ\Cachet\Console\Commands\FixPermissionsCommand;
use CachetHQ\Cachet\Console\Commands\OneClickDeployCommand;
use Illuminate\Support\ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands('CachetHQ\Cachet\Console\Commands\FixPermissionsCommand');
        $this->commands('CachetHQ\Cachet\Console\Commands\OneClickDeployCommand');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('CachetHQ\Cachet\Console\Commands\FixPermissionsCommand', function ($app) {
            return new FixPermissionsCommand();
        });

        $this->app->singleton('CachetHQ\Cachet\Console\Commands\OneClickDeployCommand', function ($app) {
            return new OneClickDeployCommand($app->environment('heroku'));
        });
    }
}
