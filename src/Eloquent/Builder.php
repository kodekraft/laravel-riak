<?php

namespace Kodekraft\Eloquent;

use Basho\Riak\Command\Builder\DeleteObject;
use Basho\Riak\Command\Builder\StoreObject;
use Basho\Riak\Location;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

/**
 * Class Builder
 *
 * @package Kodekraft\Eloquent
 */
class Builder extends EloquentBuilder
{
    /**
     * Insert a new record into the database.
     *
     * @param array $values
     *
     * @return bool
     */
    public function insert(array $values)
    {
        return (new StoreObject($this->query->getConnection()->getRiak()))
            ->atLocation(new Location($this->getModel()->getKey(), $this->model->getBucket()))
            ->buildJsonObject($values)
            ->build()
            ->execute();
    }

    /**
     * Update a record in the database.
     *
     * @param array $values
     *
     * @return int
     */
    public function update(array $values)
    {
        return (new StoreObject($this->query->getConnection()->getRiak()))
            ->atLocation(new Location($this->getModel()->getKey(), $this->model->getBucket()))
            ->withObject($values)
            ->build()
            ->execute();
    }

    public function delete()
    {
        return (new DeleteObject($this->query->getConnection()->getRiak()))
            ->atLocation(new Location($this->getModel()->getKey(), $this->model->getBucket()))
            ->build()
            ->execute();

    }
}