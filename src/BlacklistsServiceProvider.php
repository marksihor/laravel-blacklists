<?php

namespace MarksIhor\LaravelBlacklists;

use Illuminate\Support\ServiceProvider;

/**
 * Class BlacklistsServiceProvider.
 */
class BlacklistsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        $this->publishes([
            \dirname(__DIR__) . '/migrations/' => database_path('migrations'),
        ], 'migrations');

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(\dirname(__DIR__) . '/migrations/');
        }
    }
}