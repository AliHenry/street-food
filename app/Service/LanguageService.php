<?php
/**
 * Created by PhpStorm.
 * User: Muhd Jibril Kazim
 * Date: 4/4/2017
 * Time: 2:58 PM
 */

namespace App\Service;


use App\Model\Language;

class LanguageService
{

    //validate rules
    protected $rules = [
        'iso_code' => 'required|string',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function selectAllLanguages()
    {
        return Language::get();
    }


    /**
     * @param array $data
     * @param array $message
     * @return bool|\Illuminate\Database\Eloquent\Model|null|static
     */
    public function selectOneLanguage(array $data, array &$message = [])
    {
        $validator = \Validator::make($data, $this->rules);

        if ($validator->fails()) {
            $message = $validator->messages();

            return false;
        }

        return Language::where('iso_code', $data['iso_code'])->first();
    }


    /**
     * @return string
     */
    public static function langISO()
    {
        //get current language and if null take default language
        return (\App::getLocale()) ? \App::getLocale() : DEFAULT_LANG;
    }
}