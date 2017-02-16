<?php

namespace Kodekraft\Query;

use Basho\Riak;
use Illuminate\Database\Query\Builder as BaseBuilder;
use Kodekraft\Connection;

/**
 * Class Builder
 *
 * @package Kodekraft\Query
 */
class Builder extends BaseBuilder
{
    /**
     * @var Riak\Bucket
     */
    protected $bucket;

    /**
     * Builder constructor.
     *
     * @param Connection $connection
     * @param Processor  $processor
     */
    public function __construct(Connection $connection, Processor $processor)
    {
        $this->grammar = new Grammar;
        $this->connection = $connection;
        $this->processor = $processor;
    }

    /**
     * @param string $bucket
     *
     * @return Builder
     */
    public function from($bucket)
    {
        if ($bucket) {
            $this->bucket = $this->connection->getBucket($bucket);
        }

        return parent::from($bucket);
    }
}