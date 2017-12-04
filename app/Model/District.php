<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\District
 *
 * @property string $district_uuid
 * @property string $city_code
 * @property string $short_name
 * @property string $long_name
 * @property string|null $type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\District whereCityCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\District whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\District whereDistrictUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\District whereLongName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\District whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\District whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\District whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
