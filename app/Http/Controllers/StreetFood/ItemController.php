<?php

namespace App\Http\Controllers\StreetFood;

use App\Http\Controllers\StreetFoodController;
use App\Service\ItemSercice;
use App\Service\ResponseService;

class ItemController extends StreetFoodController
{
    //messages
    protected $messages = [];

    public function featuredItem(ItemSercice $service)
    {
        $input = $this->input;

        try{
            $items = $service->featured($input, $this->messages);

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

    public function allItem(ItemSercice $service)
    {
        $input = $this->input;

        try{
            $items = $service->allItem();

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

    public function searchItem(ItemSercice $service)
    {
        $input = $this->input;

        try{
            $items = $service->search($input, $this->messages);

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
