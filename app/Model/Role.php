<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Role
 *
 * @property string $role_uuid
 * @property string $name
 * @property string|null $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Role whereRoleUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends Model
{
    protected $table = 'roles';

    protected $primaryKey = 'role_uuid';

    public $incrementing = false;

    protected $casts = [
        'role_uuid' => 'string',
    ];

    protected $fillable = [
        'role_uuid', 'name',
    ];


    protected $hidden = [
        'created_at', 'deleted_at', 'updated_at'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role', 'role_uuid', 'user_uuid');
    }
}
