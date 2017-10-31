<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //set table name
    protected $table = 'city';

    //set to false since we using uuid
    public $incrementing = false;

    //set primary key
    protected $primaryKey = 'city_uuid';

    //set fillables for create method
    protected $fillable = [
        'city_uuid',
        'country_code',
        'short_name',
        'long_name',
        'type'
    ];

    //cast primary key to string
    protected $casts = [
        'city_uuid'     => 'string',
        'country_uuid'  => 'string'
    ];
}
