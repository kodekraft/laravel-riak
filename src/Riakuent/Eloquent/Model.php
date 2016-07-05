<?php

namespace Riakuent\Eloquent;

use Basho\Riak\Bucket;
use Basho\Riak\DataType\Map;
use Basho\Riak\Location;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Riakuent\Query\Builder as QueryBuilder;

/**
 * Class Model
 *
 * @package Riakuent\Eloquent
 */
abstract class Model extends BaseModel
{
    use HybridRelations;

    /**
     * The bucket associated with the model.
     *
     * @var Bucket|null
     */
    protected $bucket = null;

    /**
     * The data map associated with the model.
     *
     * @var Map|null
     */
    protected $data = null;

    /**
     * The location associated with the model.
     *
     * @var Location
     */
    protected $location;

    /**
     * Riak does not use auto-incrementing ids
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Model constructor.
     *
     * @param array $attributes
     *
     * @throws \Exception
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (is_null($this->bucket)) {
            throw new \Exception('Bucket name not supplied for ' . __CLASS__ . ' model');
        }

        $this->bucket = new Bucket($this->bucket);
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Riakuent\Query\Builder $query
     *
     * @return \Riakuent\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    /**
     * Get a new query builder instance for the connection.
     *
     * @return Builder
     */
    protected function newBaseQueryBuilder()
    {
        $connection = $this->getConnection();

        return new QueryBuilder($connection, $connection->getPostProcessor());
    }

    /**
     * Returns the bucket for the model.
     *
     * @return Bucket|null
     */
    public function getBucket()
    {
        return $this->bucket;
    }


    /**
     * Get the format for database stored dates.
     *
     * @return string
     */
    protected function getDateFormat()
    {
        return $this->dateFormat ?: 'Y-m-d H:i:s';
    }

    /**
     * Handle dynamic method calls into the method.
     *
     * @param  string $method
     * @param  array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        // Unset method
        if ($method == 'unset') {
            return call_user_func_array([$this, 'drop'], $parameters);
        }

        return parent::__call($method, $parameters);
    }
}