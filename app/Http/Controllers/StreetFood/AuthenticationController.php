<?php

namespace App\Http\Controllers\StreetFood;

use App\Http\Controllers\StreetFoodController;
use App\Service\CustomerService;
use App\Service\ResponseService;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticationController extends StreetFoodController
{
    //messages
    protected $messages = [];

    public function login(CustomerService $service)
    {
        $input = $this->input;

        try{
            $result = $service->loginCustomer($input, $this->messages);

            if ($result) {
                return ResponseService::success([
                    'message' => ['operation success'],
                    'data'    => $result
                ]);
            }
            return ResponseService::error(['message' => $this->messages]);
        }catch (\Exception $e){
            return ResponseService::exceptionError($e);
        }
    }


    public function logout()
    {
        if (\JWTAuth::invalidate($this->token)) {
            return ResponseService::success([
                'message' => ['your are logout'],
            ]);
        }
        return ResponseService::error(['message' => $this->messages]);

    }
}
