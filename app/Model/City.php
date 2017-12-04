<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\City
 *
 * @property string $city_uuid
 * @property string $country_code
 * @property string $short_name
 * @property string $long_name
 * @property string|null $type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\City whereCityUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\City whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\City whereLongName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\City whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\City whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\City whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
