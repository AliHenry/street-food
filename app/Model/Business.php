<?php

namespace App\Model;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{

    //for locale multi language
    use Translatable;

    //
    public $translatedAttributes = ['name', 'description'];

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
        'logo',
        'address',
        'country_uuid',
        'city_uuid',
        'district_uuid',
        'phone',
        'long',
        'lat'
    ];

    //hide these fields when selecting
    protected $hidden = [
        'deleted_at',
    ];

    public function country(){
        return $this->belongsTo(Country::class, 'country_uuid');
    }

    public function city(){
        return $this->belongsTo(City::class, 'city_uuid');
    }

    public function district(){
        return $this->belongsTo(District::class, 'district_uuid');
    }


}
