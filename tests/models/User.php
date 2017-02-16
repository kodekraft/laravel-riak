<?php

use Kodekraft\Eloquent\Model as Model;

/**
 * Class User
 */
class User extends Model
{
    protected $bucket = 'users';

    protected $primaryKey = 'userId';

    protected static $unguarded = true;
}