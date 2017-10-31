<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //set table name
    protected $table = 'country';

    //set to false since we using uuid
    public $incrementing = false;

    //set primary key
    protected $primaryKey = 'country_uuid';

    //set fillables for create method
    protected $fillable = [
        'country_uuid',
        'short_name',
        'long_name',
        'type'
    ];

    //cast primary key to string
    protected $casts = [
        'country_uuid' => 'string',
    ];



}
