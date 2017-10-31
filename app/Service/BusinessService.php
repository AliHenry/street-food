<?php
/**
 * Created by PhpStorm.
 * User: Alee
 * Date: 9/13/17
 * Time: 9:34 PM
 */

namespace App\Service;

use App\Mail\SignUpVerification;
use App\Model\Business;
use App\Model\City;
use App\Model\Country;
use App\Model\District;
use App\Model\Profile;
use App\Model\Role;
use App\Model\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

class BusinessService
{

    // define the rules for registration step one
    protected $rules = [
        'email'    => 'required|string',
        'password' => 'required|string|min:6',
        'name'     => 'required|string',
    ];

    //define the rules for verification step 2 by code or verification token
    protected $verifyRules = [
        'verification_token' => 'sometimes|required|string',
        'code'               => 'sometimes|required|string',
    ];

    //define the rules for business registration step 3
    protected $bizRules = [
        'name'               => 'required|string',
        'address'            => 'sometimes|required|string',
        'geometry'           => 'sometimes|required|array',
        'address_components' => 'sometimes|required|array',
    ];

    //define the rules for location
    protected $createLocationRules = [
        'short_name' => 'required|string',
        'long_name'  => 'required|string',
    ];

    /******** START OF BUSINESS ONBOARDING ************/

    public function createBizUser(array $data, &$message = [])
    {
        $data['user_uuid'] = UUIDService::generateUUId();
        $data['role'] = 'Admin';

        //validation
        $validator = \Validator::make($data, $this->rules);

        //if validation fails return error message
        if ($validator->fails()) {
            $message = $validator->messages();

            return false;
        }

        $checkUser = User::where('email', $data['email'])->first();

        if ($checkUser) {
            //front end url
            $url = 'http://localhost:9000/business/#/verify/';

            //send email with verification code and token
            Mail::to($checkUser)->send(new SignUpVerification($checkUser));
        } elseif (User::where('email', $data['email'])->where('verified', 1)->first()) {
            $message = 'user already verified';

            return false;
        } else {

            //set user in user object
            $user = New User();
            $user->user_uuid = $data['user_uuid'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->name = $data['name'];
            $user->code = $this->generateRandomString(6);
            $user->verification_token = $this->generateToken();

            //save user
            $user->save();

            //check if role exist
            $role = Role::where('name', $data['role'])->first();

            //if role doesn't exist return message
            if (!$role) {
                $message = 'no role found';

                return false;
            }

            //attach user role relationship
            $user->roles()->attach($role);

            //front end url
            $url = 'http://localhost:9000/business/#/verify/';

            //send email with verification code and token
            Mail::to($user)->queue(new SignUpVerification($user));
        }

        $data = [
            'message' => 'verification code has been sent to your email',
        ];

        //return data
        return $data;
    }

    public function verifyBizUser(array $data, &$message = [])
    {

        //validation
        $validator = \Validator::make($data, $this->verifyRules);

        //if validation fails return error message
        if ($validator->fails()) {
            $message = $validator->messages();

            return false;
        }

        $user = $this->getUser($data);

        //send error message if no user with code found
        if (!$user) {
            $message = 'no user found with this code';

            return false;
        }

        //udate user information
        $user->verified = 1;
        $user->save();

        //make token
        $token = JWTAuth::fromUser($user);

        // generate refresh token
        $config = config('jwt.refresh_ttl');
        $refreshToken = \JWTAuth::fromUser($user, [
            'exp'              => time() + $config * 60,
            'is_refresh_token' => true,
        ]);

        $result = [
            "token"         => $token,
            "refresh_token" => $refreshToken,
            "user"          => $user,
        ];

        //return result
        return $result;
    }

    public function createVarifiedBusiness(array $data, &$message = [])
    {
        //validation
        $validator = \Validator::make($data, $this->bizRules);

        //if validation fails return error message
        if ($validator->fails()) {
            $message = $validator->messages();

            return false;
        }

        //get user from token
        $userFromToken = JWTAuth::toUser($data['token']);

        $user = User::find($userFromToken->user_uuid);

        if (!$user) {
            $message = 'no user found or user not varified';

            return false;
        }

        $data['user_uuid'] = $user->user_uuid;

        $business = Business::where('user_uuid', $user->user_uuid)->first();

        //check if business exist
        if (!$business) {
            // create business
            $business = $this->createBusiness($data, $message);
        } else {
            // update buisness
            $data['biz_uuid'] = $business->biz_uuid;
            $business = $this->updateBusiness($data, $message);
        }

        //get country object
        $business->country;

        //get city object
        $business->city;

        //get district object
        $business->district;

        //return business
        return $business;
    }

    /******** END OF BUSINESS ONBOARDING ************/

    /******** START OF BUSINESS FUNCTIONS ************/
    public function createBusiness(array $data, &$message = [])
    {
        //set biz uuid
        $data['biz_uuid'] = UUIDService::generateUUID();

        //validation
        $validator = \Validator::make($data, $this->bizRules);

        //if validation fails return error message
        if ($validator->fails()) {
            $message = $validator->messages();

            return false;
        }

        foreach ($data['address_components'] as $component) {
            foreach ($component['types'] as $type) {
                if ($type == 'country') {
                    $data['country'] = [
                        'short_name' => $component['short_name'],
                        'long_name'  => $component['long_name'],
                        'type'       => $type,
                    ];
                }

                if ($type == 'administrative_area_level_1') {
                    $data['city'] = [
                        'short_name' => $component['short_name'],
                        'long_name'  => $component['long_name'],
                        'type'       => $type,
                    ];
                }

                if ($type == 'administrative_area_level_2') {
                    $data['district'] = [
                        'short_name' => $component['short_name'],
                        'long_name'  => $component['long_name'],
                        'type'       => $type,
                    ];
                }
            }
        }

        $country = $this->createCountry($data['country'], $message);

        $data['country_uuid'] = $country->country_uuid;
        if ($country) {
            $data['city']['country_code'] = $country->short_name;
            $city = $this->createCity($data['city'], $message);
            if ($city) {
                $data['city_uuid'] = $city->city_uuid;
                $data['district']['city_code'] = $city->short_name;
                $district = $this->createDistrict($data['district'], $message);
                if ($district) {
                    $data['district_uuid'] = $district->district_uuid;
                }
            }
        }

        //get long lat from geometry
        $data['long'] = $data['geometry']['long'];
        $data['lat'] = $data['geometry']['lat'];

        //create business
        $business = Business::create($data);

        //create translation if business created
        if ($business) {
            if (LanguageService::langISO() !== DEFAULT_LANG) {
                $business->{'name:en'} = $data['name'];
                $business->save();
            }

            unset($business->translations);
        }

        //return business
        return $business;
    }

    public function updateBusiness(array $data, &$message = [])
    {
        //get business
        $business = Business::where('biz_uuid', $data['biz_uuid'])->first();
        //confirm business exist or not
        if (!$business) {
            $message = 'business does not exist';

            return false;
        }

        $country = null;

        foreach ($data['address_components'] as $component) {
            foreach ($component['types'] as $type) {
                if ($type == 'country') {
                    $data['country'] = [
                        'short_name' => $component['short_name'],
                        'long_name'  => $component['long_name'],
                        'type'       => $type,
                    ];
                }

                if ($type == 'administrative_area_level_1') {
                    $data['city'] = [
                        'short_name' => $component['short_name'],
                        'long_name'  => $component['long_name'],
                        'type'       => $type,
                    ];
                }

                if ($type == 'administrative_area_level_2') {
                    $data['district'] = [
                        'short_name' => $component['short_name'],
                        'long_name'  => $component['long_name'],
                        'type'       => $type,
                    ];
                }
            }
        }

        // update country
        $data['country']['country_uuid'] = $business->country_uuid;
        !isset($data['country']) ?: $country = $this->updateCountry($data['country'], $message);

        // update city
        $data['city']['city_uuid'] = $business->city_uuid;
        !isset($data['city']) ?: $city = $this->updateCity($data['city'], $message);

        // update district
        $data['district']['district_uuid'] = $business->district_uuid;
        !isset($data['district']) ?: $district = $this->updateDistrict($data['district'], $message);

        //return translation or create a new locale
        $translation = $business->translateOrNew(LanguageService::langISO());
        $translation->biz_uuid = $business->biz_uuid;
        //if a name or description param is provided
        !isset($data['name']) ?: $translation->name = $data['name'];
        !isset($data['description']) ?: $translation->description = $data['description'];
        //save new locale if created
        $translation->save();

        //update the rest of the fields
        !isset($data['address']) ?: $business->address = $data['address'];
        !isset($data['phone']) ?: $business->phone = $data['phone'];
        !isset($data['logo']) ?: $business->logo = $data['logo'];
        !isset($data['long']) ?: $business->long = $data['long'];
        !isset($data['lat']) ?: $business->lat = $data['lat'];

        //save
        $business->save();

        unset($business->translations);

        //return business
        return $business;
    }

    /******** END OF BUSINESS FUNCTIONS ************/

    /******** START OF EXTRA FUNCTIONS ************/

    private function generateToken()
    {
        return hash_hmac('sha256', str_random(30), config('app.key'));
    }

    public function generateRandomString($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[ rand(0, $charactersLength - 1) ];
        }
        $count = User::where('code', $randomString)->count();

        if ($count > 0) {
            $this->generateRandomString($length);
        }

        return $randomString;
    }

    public function getBizOrProfleRole(User $user)
    {

        //check if role isset and its Admin
        if (isset($user->role) && $user->role == 'Admin') {
            $biz = Business::where('user_uuid', $user->user_uuid)->first();

            return ['business' => $biz];
        } elseif (isset($user->role) && $user->role == 'User') //check if role isset and its User
        {
            $profile = Profile::where('user_uuid', $user->user_uuid)->first();

            return ['profile' => $profile];
        }

        //return false if non is true
        return false;
    }

    public function CheckUserRole(User $user)
    {
        //initials name
        $name = '';

        if (isset($user)) {
            foreach ($user->roles as $role) {
                $name = $role->name;
            }

            return $name;
        }

        return false;
    }

    public function getUser($data)
    {
        //get user from token
        if (isset($data['verification_token']) && !$data['verification_token'] == null) {
            return User::where('verification_token', $data['verification_token'])->first();
        }

        //check for verification code
        if (isset($data['code']) && !$data['code'] == null) {
            return User::where('code', $data['code'])->first();
        }

        return false;
    }

    /******** END OF EXTRA FUNCTIONS ************/

    /******* START OF OUTLET COUNTRY, CITY AND DISTRICT **********/

    public function createCountry(array $data, array &$message = [])
    {
        //set country uuid
        $data['country_uuid'] = UUIDService::generateUUID();

        //check validation rules
        $validator = \Validator::make($data, $this->createLocationRules);

        if ($validator->fails()) {
            $message = $validator->messages();

            return false;
        }

        // create country
        $country = Country::create($data);

        //check if not created return false and message
        if (!$country) {
            $message = 'country was not created';

            return false;
        }

        //return country
        return $country;
    }

    public function updateCountry(array $data, array &$message = [])
    {

        //check validation rules
        $validator = \Validator::make($data, $this->createLocationRules);

        if ($validator->fails()) {
            $message = $validator->messages();

            return false;
        }

        // find country
        $country = Country::find($data['country_uuid']);

        //check if not created return false and message
        if (!$country) {
            $message = 'country was not created';

            return false;
        }

        // update country
        //udate district
        !isset($data['short_name']) ?: $country->short_name = $data['short_name'];
        !isset($data['long_name']) ?: $country->long_name = $data['long_name'];
        !isset($data['type']) ?: $country->type = $data['type'];
        $country->update();

        //return country
        return $country;
    }

    public function createCity(array $data, array &$message = [])
    {
        //set city uuid
        $data['city_uuid'] = UUIDService::generateUUID();

        //check validation rules
        $validator = \Validator::make($data, $this->createLocationRules);

        if ($validator->fails()) {
            $message = $validator->messages();

            return false;
        }

        // create city
        $city = City::create($data);

        //check if not created return false and message
        if (!$city) {
            $message = 'city was not created';

            return false;
        }

        //return city
        return $city;
    }

    public function updateCity(array $data, array &$message = [])
    {

        //check validation rules
        $validator = \Validator::make($data, $this->createLocationRules);

        if ($validator->fails()) {
            $message = $validator->messages();

            return false;
        }

        // find city
        $city = City::find($data['city_uuid']);

        //check if not created return false and message
        if (!$city) {
            $message = 'city not found';

            return false;
        }

        //update city
        !isset($data['short_name']) ?: $city->short_name = $data['short_name'];
        !isset($data['long_name']) ?: $city->long_name = $data['long_name'];
        !isset($data['type']) ?: $city->type = $data['type'];
        $city->update();

        //return country
        return $city;
    }

    public function createDistrict(array $data, array &$message = [])
    {
        //set district uuid
        $data['district_uuid'] = UUIDService::generateUUID();

        //check validation rules
        $validator = \Validator::make($data, $this->createLocationRules);

        if ($validator->fails()) {
            $message = $validator->messages();

            return false;
        }

        // create district
        $district = District::create($data);

        //check if not created return false and message
        if (!$district) {
            $message = 'district was not created';

            return false;
        }

        //return city
        return $district;
    }

    public function updateDistrict(array $data, array &$message = [])
    {

        //check validation rules
        $validator = \Validator::make($data, $this->createLocationRules);

        if ($validator->fails()) {
            $message = $validator->messages();

            return false;
        }

        // find district
        $district = District::find($data['district_uuid']);

        //check if not created return false and message
        if (!$district) {
            $message = 'district not found';

            return false;
        }

        //udate district
        !isset($data['short_name']) ?: $district->short_name = $data['short_name'];
        !isset($data['long_name']) ?: $district->long_name = $data['long_name'];
        !isset($data['type']) ?: $district->type = $data['type'];
        $district->update();

        //return district
        return $district;
    }
    /*******  END OF OUTLET COUNTRY, CITY AND DISTRICT **********/
}