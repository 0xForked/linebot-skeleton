<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
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
    protected $table = 'event_log';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'id',
        'signature',
        'events'
    ];

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = [
        'created_at'
    ];

}
