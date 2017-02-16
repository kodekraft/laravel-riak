<?php

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Application;
use Illuminate\Auth\Passwords\PasswordResetServiceProvider;

/**
 * Class TestCase
 */
class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Get application providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getApplicationProviders($app)
    {
        $providers = parent::getApplicationProviders($app);
        unset($providers[array_search(PasswordResetServiceProvider::class, $providers)]);
        return $providers;
    }

    /**
     * Get package providers.
     *
     * @param  Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            Kodekraft\RiakServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // reset base path to point to our package's src directory
        //$app['path.base'] = __DIR__ . '/../src';

        $config = require 'config/database.php';

        $app['config']->set('app.key', 'ZsZewWyUJ5FsKp9lMwv4tYbNlegQilM7');

        $app['config']->set('database.default', 'riak');
        $app['config']->set('database.connections.mysql', $config['connections']['mysql']);
        $app['config']->set('database.connections.riak', $config['connections']['riak']);

        $app['config']->set('auth.model', 'User');
        $app['config']->set('auth.providers.users.model', 'User');
        $app['config']->set('cache.driver', 'array');

        $app['config']->set('queue.default', 'database');
        $app['config']->set('queue.connections.database', [
            'driver' => 'riak',
            'table'  => 'jobs',
            'queue'  => 'default',
            'expire' => 60,
        ]);
    }

    /**
     * Set the currently logged in user for the application.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  string                                     $driver
     *
     * @return void
     */
    public function be(Authenticatable $user, $driver = null)
    {
        // TODO: Implement be() method.
    }
}
