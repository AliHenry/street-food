<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

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
