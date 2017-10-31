<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

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
