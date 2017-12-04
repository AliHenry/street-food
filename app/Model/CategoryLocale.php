<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Model\CategoryLocale
 *
 * @property string $category_uuid
 * @property string $lang_iso_code
 * @property string $name
 * @property \Carbon\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Model\CategoryLocale onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CategoryLocale whereCategoryUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CategoryLocale whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CategoryLocale whereLangIsoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CategoryLocale whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Model\CategoryLocale withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Model\CategoryLocale withoutTrashed()
 * @mixin \Eloquent
 */
class CategoryLocale extends Model
{
    //for soft deletes
    use SoftDeletes;

    //set to use for soft deletes
    protected $dates = ['deleted_at'];

    //set table name
    protected $table = 'category_locale';

    //set to false to not use laravel dates
    public $timestamps = false;

    //set fillables for create method
    protected $fillable = [
        'category_uuid',
        'lang_iso_code',
        'name',
    ];

    //hide these fields when selecting
    protected $hidden = [
        'deleted_at',
    ];
}
