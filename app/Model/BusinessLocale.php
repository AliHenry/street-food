<?php

namespace App\Model;

use App\Model\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Model\BusinessLocale
 *
 * @property string $biz_uuid
 * @property string $lang_iso_code
 * @property string $name
 * @property string|null $description
 * @property \Carbon\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Model\BusinessLocale onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BusinessLocale whereBizUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BusinessLocale whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BusinessLocale whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BusinessLocale whereLangIsoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BusinessLocale whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Model\BusinessLocale withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Model\BusinessLocale withoutTrashed()
 * @mixin \Eloquent
 */
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
