<?php

namespace Kodekraft\Eloquent;

/**
 * Class SoftDeletes
 *
 * @package Kodekraft\Eloquent
 */
trait SoftDeletes
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    /**
     * Get the fully qualified "deleted at" column.
     *
     * @return string
     */
    public function getQualifiedDeletedAtColumn()
    {
        return $this->getDeletedAtColumn();
    }
}