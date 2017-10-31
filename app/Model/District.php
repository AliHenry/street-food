<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    //set table name
    protected $table = 'district';

    //set to false since we using uuid
    public $incrementing = false;

    //set primary key
    protected $primaryKey = 'district_uuid';

    //set fillables for create method
    protected $fillable = [
        'district_uuid',
        'city_code',
        'short_name',
        'long_name',
        'type'
    ];

    //cast primary key to string
    protected $casts = [
        'district_uuid' => 'string',
        'city_uuid'     => 'string'
    ];
}
