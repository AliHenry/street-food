<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Language
 *
 * @property int $id
 * @property string $name
 * @property string $iso_code
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Language whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Language whereIsoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Language whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Language whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Language extends Model
{
    //name of table
    protected $table = 'languages';

    //set to false to not use laravel dates
    public $timestamps = false;

    //set fillables for create method
    protected $fillable = [
        'name',
        'iso_code',
    ];
}
