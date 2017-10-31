<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemLocale extends Model
{
    //for soft deletes
    use SoftDeletes;

    //set to use for soft deletes
    protected $dates = ['deleted_at'];

    //set table name
    protected $table = 'item_locale';

    //set to false to not use laravel dates
    public $timestamps = false;

    //set fillables for create method
    protected $fillable = [
        'item_uuid',
        'lang_iso_code',
        'name',
        'description'
    ];

    //hide these fields when selecting
    protected $hidden = [
        'deleted_at',
    ];
}
