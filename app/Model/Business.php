<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $table = 'business';

    protected $primaryKey = 'biz_uuid';

    public $incrementing = false;

    protected $casts = [
        'biz_uuid' => 'string',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'biz_uuid',
        'user_uuid',
        'name',
        'description',
        'logo',
        'address',
        'street',
        'city',
        'district',
        'zip',
        'phone',
        'long',
        'lat'
    ];


}
