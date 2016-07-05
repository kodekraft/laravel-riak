<?php

use Riakuent\Eloquent\Model as Model;

/**
 * Class Market
 */
class Market extends Model
{
    protected $bucket = 'Markets';

    protected $primaryKey = 'marketId';

    protected static $unguarded = true;

    public function competition()
    {
        return $this->hasOne('Events');
    }

    public function selections()
    {
        return $this->hasMany('Selections');
    }
}