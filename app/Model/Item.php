<?php

namespace App\Model;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Model\Item
 *
 * @property string $item_uuid
 * @property string $biz_uuid
 * @property string $category_uuid
 * @property float $price
 * @property string|null $image
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\ItemLocale[] $translations
 * @method static bool| forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Item listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Item notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Query\Builder|\App\Model\Item onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Item orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Item orWhereTranslationLike($key, $value, $locale = null)
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Item translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Item translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Item whereBizUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Item whereCategoryUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Item whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Item whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Item whereItemUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Item wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Item whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Item whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Item withTranslation()
 * @method static \Illuminate\Database\Query\Builder|\App\Model\Item withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Model\Item withoutTrashed()
 * @mixin \Eloquent
 */
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
        'photo',
        'price',
    ];

    //hide these fields when selecting
    protected $hidden = [
        'deleted_at',
    ];

}
