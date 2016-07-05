<?php

namespace Riakuent;

use Basho\Riak;
use Exception;

/**
 * Class Bucket
 *
 * @package Riakuent
 */
class Bucket
{
    /**
     * The connection instance.
     *
     * @var Connection
     */
    protected $connection;

    /**
     * The Riak bucket instance.
     *
     * @var Riak\Bucket
     */
    protected $bucket;

    /**
     * Collection constructor.
     *
     * @param Connection  $connection
     * @param Riak\Bucket $bucket
     */
    public function __construct(Connection $connection, Riak\Bucket $bucket)
    {
        $this->connection = $connection;
        $this->bucket = $bucket;
    }

    /**
     * Handle dynamic method calls.
     *
     * @param  string $method
     * @param  array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $start = microtime(true);

        $result = call_user_func_array([$this->bucket, $method], $parameters);

        if ($this->connection->logging()) {
            // Once we have run the query we will calculate the time that it took to run and
            // then log the query, bindings, and execution time so we will report them on
            // the event that the developer needs them. We'll log time in milliseconds.
            $time = $this->connection->getElapsedTime($start);

            $query = [];

            // Convert the query parameters to a json string.
            foreach ($parameters as $parameter) {
                try {
                    $query[] = json_encode($parameter);
                } catch (Exception $e) {
                    $query[] = '{...}';
                }
            }

            $queryString = $this->bucket->getName() . '.' . $method . '(' . implode(',', $query) . ')';

            $this->connection->logQuery($queryString, [], $time);
        }

        return $result;
    }
}