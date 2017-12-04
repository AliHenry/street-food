<?php
/**
 * Created by PhpStorm.
 * User: Alee
 * Date: 10/8/17
 * Time: 9:52 PM
 */

namespace App\Service;

use App\Model\Category;
use App\Model\Item;
use Illuminate\Support\Facades\DB;

class ItemSercice
{

    protected $rules = [
        'biz_uuid'      => 'required|string',
        'category_uuid' => 'required|string',
        'name'          => 'required|string',
        'description'   => 'sometimes|required|string',
        'price'         => 'required|numeric',
        'image'         => 'sometimes|required|string',
    ];

    protected $updateRules = [
        'item_uuid'   => 'required|string',
        'name'        => 'sometimes|required|string',
        'description' => 'sometimes|required|string',
        'price'       => 'sometimes|required|numeric',
        'image'       => 'sometimes|required|string',
    ];

    protected $featuredRules = [
        'keyword' => 'sometimes|required|string',
    ];

    public function createItem(array $data, &$message = [])
    {
        //set category uuid
        $data['item_uuid'] = UUIDService::generateUUID();

        //validation
        $validator = \Validator::make($data, $this->rules);

        //if validation fails return error message
        if ($validator->fails()) {
            $message = $validator->messages();

            return false;
        }

        //create item
        $item = Item::create($data);

        if ($item) {
            //set translation
            if (LanguageService::langISO() !== DEFAULT_LANG) {
                $item->{'name:en'} = $data['name'];
                !isset($data['description']) ?: $item->{'description:en'} = $data['description'];
                $item->save();
            }

            //unset translation
            unset($item->translations);
        }

        //return item
        return $item;
    }

    public function updateItem(array $data, &$message = [])
    {
        //validation
        $validator = \Validator::make($data, $this->updateRules);

        //if validation fails return error message
        if ($validator->fails()) {
            $message = $validator->messages();

            return false;
        }

        // find item
        $item = Item::where('item_uuid', $data['item_uuid'])->first();

        if (!$item) {
            $message = 'item not found';

            return false;
        }

        //update translation or create a new locale
        $translation = $item->translateOrNew(LanguageService::langISO());
        $translation->item_uuid = $data['item_uuid'];
        //
        !isset($data['name']) ?: $translation->name = $data['name'];
        !isset($data['description']) ?: $translation->description = $data['description'];
        //save new locale if created
        $translation->save();

        !isset($data['price']) ?: $item->price = $data['price'];
        !isset($data['image']) ?: $item->price = $data['image'];

        //save item
        $item->save();

        //return item
        return $item;
    }

    public function allItem()
    {
        return Item::paginate(10);
    }

    public function featured(array $data, &$message = [])
    {
        //validation
        $validator = \Validator::make($data, $this->featuredRules);

        //if validation fails return error message
        if ($validator->fails()) {
            $message = $validator->messages();

            return false;
        }

        $items = Item::whereTranslationLike('name', '%'.$data['keyword'].'%')
            ->limit(5)
            ->get();

        return $items;
    }

    public function search(array $data, &$message = [])
    {
        //validation
        $validator = \Validator::make($data, $this->featuredRules);

        //if validation fails return error message
        if ($validator->fails()) {
            $message = $validator->messages();

            return false;
        }

        $items = Item::whereTranslationLike('name', '%'.$data['keyword'].'%')
            ->paginate(10);

        return $items;
    }

    public function selectItem(array $data, &$message = [])
    {
        //validation
        $validator = \Validator::make($data, $this->updateRules);

        //if validation fails return error message
        if ($validator->fails()) {
            $message = $validator->messages();

            return false;
        }

        // find item
        $item = Item::where('item_uuid', $data['item_uuid'])->first();

        if (!$item) {
            $message = 'item not found';

            return false;
        }

        //return item
        return $item;
    }
}