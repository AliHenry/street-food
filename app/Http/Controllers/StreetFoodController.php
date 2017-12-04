<?php

namespace App\Http\Controllers;

use App\Service\LanguageService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Intervention\Image\ImageManagerStatic as Image;

class StreetFoodController extends Controller
{
    public $request, $input, $token, $user, $lang, $photo;

    /**
     * HottabController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->token = $request->get('token', request()->header('token'));

        if ($request->hasFile('photo')){
            $image = $request->file('photo');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $location = public_path('img/'.$filename);
            Image::make($image)->resize(400, 400)->save($location);
            $this->photo = $filename;
        }

        //get the logged in user
        if ($this->token) {
            try {
                $this->user = \JWTAuth::toUser($this->token);
            } catch (TokenExpiredException $e) {
                return [
                    'error' => 'token_expired',
                ];
            } catch (TokenInvalidException $e) {
                return [
                    'error' => 'token_invalid',
                ];
            } catch (JWTException $e) {
                return [
                    'error' => 'token_absent',
                ];
            } catch (\Exception $e) {
                //\Log::error($e);
                return [
                    'error' => 'token_absent',
                ];
            }

        }

        $input = $request->all();
        $input['photo'] = $this->photo;
        //set input
        $this->input = $input;

        //set language
        $this->setLanguage($request);

    }

    /**
     * @param Request $request
     */
    private function setLanguage(Request $request)
    {
        $service = new LanguageService();
        $lang = $request->get('lang', DEFAULT_LANG);
        $result = $service->selectOneLanguage(['iso_code' => $lang]);
        $this->lang = $result;

        if ($this->lang) {
            \App::setLocale($this->lang->iso_code);
        } else {
            \App::setLocale(DEFAULT_LANG);
        }
    }
}
