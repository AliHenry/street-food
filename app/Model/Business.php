<?php

namespace App\Model;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Business
 *
 * @property string $biz_uuid
 * @property string $user_uuid
 * @property string|null $logo
 * @property string|null $type
 * @property string|null $address
 * @property string|null $country_uuid
 * @property string|null $city_uuid
 * @property string|null $district_uuid
 * @property string|null $phone
 * @property float|null $lng
 * @property float|null $lat
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Model\City|null $city
 * @property-read \App\Model\Country|null $country
 * @property-read \App\Model\District|null $district
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\BusinessLocale[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Business listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Business notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Business orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Business orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Business translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Business translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Business whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Business whereBizUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Business whereCityUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Business whereCountryUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Business whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Business whereDistrictUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Business whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Business whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Business whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Business wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Business whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Business whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Business whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Business whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Business whereUserUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Business withTranslation()
 * @mixin \Eloquent
 */
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
        'lng',
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
