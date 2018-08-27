<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    /**
    * Indicates if the model should be timestamped.
    *
    * @var bool
    */
    public $timestamps = false;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'users';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'id',
        'user_id',
        'display_name'
    ];


}
