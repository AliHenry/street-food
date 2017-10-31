<?php
/**
 * Created by PhpStorm.
 * User: Alee
 * Date: 10/8/17
 * Time: 9:52 PM
 */

namespace App\Service;


use App\Model\Category;

class CategoryService
{
    protected $rules = [
        'biz_uuid' => 'required|string',
        'name' => 'required|string',
    ];

    protected $updateRules = [
        'category_uuid' => 'required|string',
        'name' => 'sometimes|required|string',
        'biz_uuid' => 'sometimes|required|string'
    ];

    public function createCategory(array $data, &$message = [])
    {
        //set category uuid
        $data['category_uuid'] = UUIDService::generateUUID();

        //validation
        $validator = \Validator::make($data, $this->rules);

        //if validation fails return error message
        if ($validator->fails()) {
            $message = $validator->messages();

            return false;
        }

        //create category
        $category = Category::create($data);

        if ($category) {
            //set translation
            if (LanguageService::langISO() !== DEFAULT_LANG) {
                $category->{'name:en'} = $data['name'];
                $category->save();
            }

            //unset translation
            unset($category->translations);
        }

        //return category
        return $category;
    }


    public function updateCategory(array $data, &$message = [])
    {
        //validation
        $validator = \Validator::make($data, $this->updateRules);

        //if validation fails return error message
        if ($validator->fails()) {
            $message = $validator->messages();

            return false;
        }

        // find category
        $category = Category::where('category_uuid', $data['category_uuid'])->first();

        if(! $category){
            $message = 'category not found';

            return false;
        }

        //update translation or create a new locale
        $translation = $category->translateOrNew(LanguageService::langISO());
        $translation->category_uuid = $data['category_uuid'];
        //
        ! isset($data['name']) ?: $translation->name = $data['name'];
        //save new locale if created
        $translation->save();

        ! isset($data['biz_uuid']) ? : $category->biz_uuid = $data['biz_uuid'];

        //save category
        $category->save();


        //return category
        return $category;
    }
}