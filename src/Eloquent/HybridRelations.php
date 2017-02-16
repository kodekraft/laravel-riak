<?php

namespace Kodekraft\Eloquent;

use Kodekraft\Relations\HasMany;

/**
 * Class HybridRelations
 *
 * @package Kodekraft\Eloquent
 */
trait HybridRelations
{
    /**
     * Define a one-to-many relationship.
     *
     * @param string $related
     * @param string $foreignKey
     * @param string $localKey
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hasMany($related, $foreignKey = null, $localKey = null)
    {
        // Check if it is a relation with an original model.
        if (!is_subclass_of($related, Model::class)) {
            return parent::hasMany($related, $foreignKey, $localKey);
        }

        $foreignKey = $foreignKey ?: $this->getForeignKey();

        $instance = new $related;

        $localKey = $localKey ?: $this->getKeyName();

        return new HasMany($instance->newQuery(), $this, $foreignKey, $localKey);
    }
}