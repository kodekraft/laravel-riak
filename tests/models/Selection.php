<?php

use Riakuent\Eloquent\Model as Model;

/**
 * Class Selection
 */
class Selection extends Model
{
    protected $bucket = 'Selections';

    protected $primaryKey = 'selectionId';

    protected static $unguarded = true;

    public function market()
    {
        return $this->hasOne('Markets');
    }
}