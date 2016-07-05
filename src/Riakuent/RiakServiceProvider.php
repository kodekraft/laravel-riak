<?php

namespace Riakuent;

use Illuminate\Support\ServiceProvider;
use Riakuent\Eloquent\Model;

/**
 * Class RiakServiceProvider
 *
 * @package Riakuent
 */
class RiakServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        Model::setConnectionResolver($this->app['db']);
        Model::setEventDispatcher($this->app['events']);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Add database driver.
        $this->app->resolving('db', function ($db) {
            $db->extend('riak', function ($config) {
                return new Connection($config);
            });
        });
    }
}