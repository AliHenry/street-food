<?php

namespace App\Http\Controllers\StreetFood\Business;

use App\Http\Controllers\StreetFoodController;
use App\Service\BusinessService;
use App\Service\ResponseService;
use Illuminate\Http\Request;

class BusinessController extends StreetFoodController
{
    //messages
    protected $messages = [];

    public function registerBizUser(BusinessService $service)
    {
        $input = $this->input;

        try{
            $user = $service->createBizUser($input, $this->messages);

            if ($user) {
                return ResponseService::success([
                    'message' => ['operation success'],
                    'data'    => $user
                ]);
            }
            return ResponseService::error(['message' => $this->messages]);
        }catch (\Exception $e){
            return ResponseService::exceptionError($e);
        }
    }

    public function verifyBizUser(BusinessService $service)
    {
        $input = $this->input;

        try{
            $user = $service->verifyBizUser($input, $this->messages);

            if ($user) {
                return ResponseService::success([
                    'message' => ['operation success'],
                    'data'    => $user
                ]);
            }
            return ResponseService::error(['message' => $this->messages]);
        }catch (\Exception $e){
            return ResponseService::exceptionError($e);
        }
    }


    public function createBusiness(BusinessService $service)
    {
        $input = $this->input;

        try{
            $business = $service->createVarifiedBusiness($input, $this->messages);

            if ($business) {
                return ResponseService::success([
                    'message' => ['operation success'],
                    'data'    => $business
                ]);
            }
            return ResponseService::error(['message' => $this->messages]);
        }catch (\Exception $e){
            return ResponseService::exceptionError($e);
        }
    }
}
