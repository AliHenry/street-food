<?php

namespace App\Model;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    //for soft deletes
    use SoftDeletes;

    //for locale multi language
    use Translatable;

    //
    public $translatedAttributes = ['name', 'description'];

    //set to use for soft deletes
    protected $dates = ['deleted_at'];

    protected $table = 'item';

    protected $primaryKey = 'item_uuid';

    public $incrementing = false;

    protected $casts = [
        'item_uuid' => 'string',
        'biz_uuid' => 'string',
        'category_uuid' => 'string',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_uuid',
        'category_uuid',
        'biz_uuid',
        'image',
        'price',
    ];

    //hide these fields when selecting
    protected $hidden = [
        'deleted_at',
    ];

}
