<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Profile
 *
 * @property string $profile_uuid
 * @property string $user_uuid
 * @property string $first_name
 * @property string $last_name
 * @property string|null $dob
 * @property string|null $phone
 * @property string|null $country
 * @property string|null $city
 * @property string|null $address
 * @property string|null $photo
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Model\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Profile whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Profile whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Profile whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Profile whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Profile whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Profile whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Profile wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Profile wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Profile whereProfileUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Profile whereUserUuid($value)
 * @mixin \Eloquent
 */
class Profile extends Model
{
    protected $table = 'profiles';

    protected $primaryKey = 'profile_uuid';

    public $incrementing = false;

    protected $casts = [
        'profile_uuid' => 'string',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'profile_uuid',
        'user_uuid',
        'first_name',
        'last_name',
        'country',
        'city',
        'phone',
        'address',
        'photo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
