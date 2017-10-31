<?php

namespace App\Model;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    //for soft deletes
    use SoftDeletes;

    //for locale multi language
    use Translatable;

    //
    public $translatedAttributes = ['name'];

    //set to use for soft deletes
    protected $dates = ['deleted_at'];

    protected $table = 'business';

    protected $primaryKey = 'category_uuid';

    public $incrementing = false;

    protected $casts = [
        'category_uuid' => 'string',
        'biz_uuid' => 'string',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_uuid',
        'biz_uuid',
    ];

    //hide these fields when selecting
    protected $hidden = [
        'deleted_at',
    ];

}
