<?php

namespace App\Model;

use App\Model\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessLocale extends Model
{
    //for soft deletes
    use SoftDeletes;

    //set to use for soft deletes
    protected $dates = ['deleted_at'];

    //set table name
    protected $table = 'business_locale';

    //set to false to not use laravel dates
    public $timestamps = false;

    //set fillables for create method
    protected $fillable = [
        'biz_uuid',
        'lang_iso_code',
        'name',
        'description',
    ];

    //hide these fields when selecting
    protected $hidden = [
        'id',
        'deleted_at',
    ];

}
