<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Country
 *
 * @property string $country_uuid
 * @property string $short_name
 * @property string $long_name
 * @property string|null $type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Country whereCountryUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Country whereLongName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Country whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Country whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Country whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
