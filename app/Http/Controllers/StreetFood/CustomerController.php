<?php

namespace App\Http\Controllers\StreetFood;


use App\Http\Controllers\StreetFoodController;
use App\Model\User;
use App\Service\CustomerService;
use App\Service\ResponseService;
use Illuminate\Http\Request;

class CustomerController extends StreetFoodController
{
    //messages
    protected $messages = [];


    public function registerCustomer(CustomerService $service)
    {
        $input = $this->input;
        //$input['image'] = $request->image->store('');

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

    public function getCustomer(CustomerService $service)
    {
        $input = $this->input;

        try{
            $customer = $service->getCustomer($input, $this->messages);

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

    public function updateCustomer(CustomerService $service)
    {
        $input = $this->input;

        try{
            $customer = $service->updateCustomer($input, $this->messages);

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

    public function uploadPhoto(CustomerService $service)
    {
        $input = $this->input;

        try{
            $customer = $service->uploadPhoto($input, $this->messages);

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


    public function changePwd(CustomerService $service)
    {
        $input = $this->input;

        try{
            $customer = $service->changePwd($input, $this->messages);

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



    public function getUsers()
    {
        try{
            $user = User::all();

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

}
