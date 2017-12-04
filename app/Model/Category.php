<?php

namespace App\Model;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Model\Category
 *
 * @property string $category_uuid
 * @property string $biz_uuid
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\CategoryLocale[] $translations
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Query\Builder|\App\Model\Category onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category orWhereTranslationLike($key, $value, $locale = null)
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereBizUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereCategoryUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category withTranslation()
 * @method static \Illuminate\Database\Query\Builder|\App\Model\Category withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Model\Category withoutTrashed()
 * @mixin \Eloquent
 */
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

    protected $table = 'category';

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
