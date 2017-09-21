<?php

/**
 * Created by PhpStorm.
 * Customer: Muhd Jibril Kazim
 * Date: 4/4/2017
 * Time: 11:36 AM
 */

namespace App\Service;


use Illuminate\Support\Facades\Response;

class ResponseService extends Response
{

    public static $responseData;

    public static function success($data, $code = 200)
    {
        $data['error'] = false;
        static::$responseData = $data;

        return Response::json($data, $code);
    }

    public static function error($data, $code = 400)
    {
        $data['error'] = true;
        static::$responseData = $data;

        return Response::json($data, $code);
    }

    public static function exceptionError(\Exception $e)
    {
        $data = [
            'message'        => 'operation failed',
            'detail_message' => $e->getMessage(),
        ];

        return static::error($data);
    }
}