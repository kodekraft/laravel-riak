<?php

namespace Kodekraft;

use Basho\Riak;

/**
 * Class Connection
 *
 * @package Kodekraft
 */
class Connection extends \Illuminate\Database\Connection
{
    /**
     * The Riak client.
     *
     * @var Riak
     */
    protected $client;

    /**
     * The Riak connection handler.
     *
     * @var Riak\Api
     */
    protected $connection;

    /**
     * Create a new database connection instance.
     *
     * @param  array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;

        $this->client = $this->createRiakClient($config);

        $this->connection = $this->client->getApi();

        $this->useDefaultPostProcessor();
    }

    /**
     * @param array $config
     *
     * @return mixed
     */
    protected function createRiakClient(array $config)
    {
        // Define the connection info to our Riak nodes
        $nodes = (new Riak\Node\Builder())
            ->onPort($config['port'])
            ->buildCluster($config['clusters']);

        // Instantiate the Riak client
        return new Riak($nodes, $config);
    }

    /**
     * Disconnect from the underlying MongoDB connection.
     */
    public function disconnect()
    {
        $this->connection->closeConnection();
        unset($this->connection);
    }

    /**
     * Get a Riak bucket
     *
     * @param string $name
     *
     * @return Bucket
     */
    public function getBucket($name)
    {
        return new Bucket($this, new Riak\Bucket($name));
    }

    /**
     * @return Riak|mixed
     */
    public function getRiak()
    {
        return $this->client;
    }

    /**
     * Get the default post processor instance.
     *
     * @return Query\Processor
     */
    protected function getDefaultPostProcessor()
    {
        return new Query\Processor;
    }

    /**
     * Begin a fluent query against a Riak bucket.
     *
     * @param string $bucket
     *
     * @return Query\Builder
     */
    protected function bucket($bucket)
    {
        $processor = $this->getPostProcessor();

        $query = new Query\Builder($this, $processor);

        return $query->from($bucket);
    }

    /**
     * Begin a fluent query against a database bucket.
     *
     * @param string $table
     *
     * @return Query\Builder
     */
    public function table($table)
    {
        return $this->bucket($table);
    }

    /**
     * Get the elapsed time since a given starting point.
     *
     * @param  int $start
     *
     * @return float
     */
    public function getElapsedTime($start)
    {
        return parent::getElapsedTime($start);
    }

    /**
     * Get the PDO driver name.
     *
     * @return string
     */
    public function getDriverName()
    {
        return 'riak';
    }
}