<?php

namespace Riakuent\Eloquent;

/**
 * Class SoftDeletes
 *
 * @package Riakuent\Eloquent
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