<?php

namespace App\Http\Controllers\StreetFood;


use App\Http\Controllers\StreetFoodController;
use App\Service\CustomerService;
use App\Service\ResponseService;

class CustomerController extends StreetFoodController
{
    //messages
    protected $messages = [];


    public function registerCustomer(CustomerService $service)
    {
        $input = $this->input;

        try{
            $customer = $service->registerCustomer($input, $this->messages);

            if ($customer) {
                return ResponseService::success([
                    'message' => ['operation success'],
                    'data'    => $customer
                ]);
            }
            return ResponseService::error(['message' => $this->messages]);
        }catch (\Exception $e){
            return ResponseService::exceptionError($e);
        }
    }

    public function loginCustomer(CustomerService $service)
    {
        $input = $this->input;

        try{
            $customer = $service->loginCustomer($input, $this->messages);

            if ($customer) {
                return ResponseService::success([
                    'message' => ['operation success'],
                    'data'    => $customer
                ]);
            }
            return ResponseService::error(['message' => $this->messages]);
        }catch (\Exception $e){
            return ResponseService::exceptionError($e);
        }
    }


    public function verifyCustomer(CustomerService $service)
    {
        $input = $this->input;

        try{
            $customer = $service->verifyCustomer($input, $this->messages);

            if ($customer) {
                return ResponseService::success([
                    'message' => ['operation success'],
                    'data'    => $customer
                ]);
            }
            return ResponseService::error(['message' => $this->messages]);
        }catch (\Exception $e){
            return ResponseService::exceptionError($e);
        }
    }

}
