<?php

/**
 * Created by PhpStorm.
 * Customer: Muhd Jibril Kazim
 * Date: 4/4/2017
 * Time: 11:44 AM
 */
namespace App\Service;

use Webpatser\Uuid\Uuid;

class UUIDService extends Uuid
{

    public static function generateUUID()
    {
        $generator = Uuid::generate();

        return $generator->__toString();
    }
}