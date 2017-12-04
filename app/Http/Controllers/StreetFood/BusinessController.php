<?php

namespace App\Http\Controllers\StreetFood\Business;

use App\Http\Controllers\StreetFoodController;
use App\Service\BusinessService;
use App\Service\CategoryService;
use App\Service\ItemSercice;
use App\Service\ResponseService;

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

    public function getBusiness(BusinessService $service)
    {
        $input = $this->input;

        try{
            $business = $service->getBusiness($input, $this->messages);

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

    public function getBizOwner(BusinessService $service)
    {
        $input = $this->input;

        try{
            $business = $service->getBizOwner($input, $this->messages);

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

    public function createCategory(CategoryService $service)
    {
        $input = $this->input;

        try{
            $category = $service->createCategory($input, $this->messages);

            if ($category) {
                return ResponseService::success([
                    'message' => ['operation success'],
                    'data'    => $category
                ]);
            }
            return ResponseService::error(['message' => $this->messages]);
        }catch (\Exception $e){
            return ResponseService::exceptionError($e);
        }
    }

    public function updateCategory(CategoryService $service, $category_uuid)
    {
        $input = $this->input;

        $input['category_uuid'] = $category_uuid;

        try{
            $category = $service->updateCategory($input, $this->messages);

            if ($category) {
                return ResponseService::success([
                    'message' => ['operation success'],
                    'data'    => $category
                ]);
            }
            return ResponseService::error(['message' => $this->messages]);
        }catch (\Exception $e){
            return ResponseService::exceptionError($e);
        }
    }

    public function createItem(BusinessService $service)
    {
        $input = $this->input;

        try{
            $item = $service->createBizItem($input, $this->messages);

            if ($item) {
                return ResponseService::success([
                    'message' => ['operation success'],
                    'data'    => $item
                ]);
            }
            return ResponseService::error(['message' => $this->messages]);
        }catch (\Exception $e){
            return ResponseService::exceptionError($e);
        }
    }

    public function getCategories(BusinessService $service)
    {
        $input = $this->input;

        try{
            $categories = $service->getBizCategory($input, $this->messages);

            if ($categories) {
                return ResponseService::success([
                    'message' => ['operation success'],
                    'data'    => $categories
                ]);
            }
            return ResponseService::error(['message' => $this->messages]);
        }catch (\Exception $e){
            return ResponseService::exceptionError($e);
        }
    }

    public function getItems(BusinessService $service)
    {
        $input = $this->input;

        try{
            $items = $service->getBizItems($input, $this->messages);

            if ($items) {
                return ResponseService::success([
                    'message' => ['operation success'],
                    'data'    => $items
                ]);
            }
            return ResponseService::error(['message' => $this->messages]);
        }catch (\Exception $e){
            return ResponseService::exceptionError($e);
        }
    }
}
