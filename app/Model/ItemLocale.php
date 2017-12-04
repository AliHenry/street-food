<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Model\ItemLocale
 *
 * @property string $item_uuid
 * @property string $lang_iso_code
 * @property string $name
 * @property string|null $description
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Model\ItemLocale onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ItemLocale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ItemLocale whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ItemLocale whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ItemLocale whereItemUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ItemLocale whereLangIsoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ItemLocale whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ItemLocale whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Model\ItemLocale withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Model\ItemLocale withoutTrashed()
 * @mixin \Eloquent
 */
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
