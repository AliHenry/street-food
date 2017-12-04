<?php
/**
 * Created by PhpStorm.
 * User: Alee
 * Date: 9/13/17
 * Time: 9:35 PM
 */

namespace App\Service;

use App\Mail\SignUpVerification;
use App\Model\Business;
use App\Model\Profile;
use App\Model\Role;
use App\Model\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Intervention\Image\File;
use Tymon\JWTAuth\Facades\JWTAuth;

class CustomerService
{

    //validation rule for login
    protected $rule = [
        'email'     => 'required|email|unique:users|email',
        'password'  => 'required|string|min:6',
        'firstname' => 'required|string',
        'lastname'  => 'required|string',
    ];

    //validation rule for login
    protected $loginRule = [
        'email'    => 'required|email',
        'password' => 'required|string',
    ];

    //validation rule for login
    protected $verifyRule = [
        'code'               => 'sometimes|required|string',
        'verification_token' => 'sometimes|required|string',
    ];

    //validation rule for login
    protected $changePwdRule = [
        'old_password' => 'required|string',
        'new_password' => 'required|string',
    ];

    //validation rule for login
    protected $photoRule = [
        'photo' => 'sometimes|required|string'
    ];

    //validation rule for login
    protected $updateProfileRule = [
        'firstname' => 'sometimes|required|string',
        'lastname'  => 'sometimes|required|string',
        'phone'     => 'sometimes|required|string',
        'address'   => 'sometimes|required|string',
        'country'   => 'sometimes|required|string',
        'city'      => 'sometimes|required|string',
    ];

    protected $messages;

    public function registerCustomer(array $data, array &$message = [])
    {
        //set user uuid
        $data['user_uuid'] = UUIDService::generateUUID();

        //set prifile uuid
        $data['profile_uuid'] = UUIDService::generateUUID();

        //set customer default role
        $data['role'] = 'User';

        $result = null;

        //validate data against rule
        $validator = \Validator::make($data, $this->rule);

        if ($validator->fails()) {
            $message = $validator->messages()->toArray();

            return false;
        }

        //create user
        $user = new User();
        $user->user_uuid = $data['user_uuid'];
        $user->name = $data['firstname'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->verified = 1;

        //save user if not return false and message
        if (!$user->save()) {
            $message = 'user not saved';

            return false;
        }

        //check if role exist
        $role = Role::where('name', $data['role'])->first();

        //if role doesn't exist return message
        if (!$role) {
            $message = 'no role found';

            return false;
        }

        //attach user role relationship
        $user->roles()->attach($role);

        //create user profile
        $profile = new Profile();
        $profile->profile_uuid = $data['profile_uuid'];
        $profile->user_uuid = $data['user_uuid'];
        $profile->first_name = $data['firstname'];
        $profile->last_name = $data['lastname'];
        $profile->photo = 'default-user.jpg';
        $profile->save();

        $user->profile;

        Mail::to($user)->queue(new SignUpVerification($user));

        return $user;
    }

    public function loginCustomer(array $data, array &$message = [])
    {

        //validate data against rule
        $validator = \Validator::make($data, $this->loginRule);

        if ($validator->fails()) {
            $message = $validator->messages()->toArray();

            return false;
        }

        //set login credentials
        $credentials = ['email' => $data['email'], 'password' => $data['password']];

        if (!$token = JWTAuth::attempt($credentials)) {
            $message = 'invalid_credentials';

            return false;
        }

        //get user from token
        $user = JWTAuth::toUser($token);

        if ($user->verified == 0) {
            $message = 'user not verified';

            return false;
        }

        // generate refresh token
        $config = config('jwt.refresh_ttl');
        $refreshToken = \JWTAuth::fromUser($user, [
            'exp'              => time() + $config * 60,
            'is_refresh_token' => true,
        ]);

        //get user role
        $user->role = $this->CheckUserRole($user);

        //check if your has no rule
        if (!$user->role) {
            $message = 'user has no role';

            return false;
        }

        // get user business(restaurant or profile)
        $userResult = $this->getBizOrProfleRole($user);

        //check if user has no profile or business (restaurant)
        if (!$userResult) {
            $message = 'user has no data';

            return false;
        }

        //unset user in the role
        unset($user->roles);

        //login data
        $result = [
            'token'         => $token,
            'refresh_token' => $refreshToken,
            'user'          => $user,
            'profile'       => $userResult,
        ];

        //return result
        return $result;
    }

    public function getCustomer(array $data, array &$message = [])
    {
        //get user from token
        $user = JWTAuth::toUser($data['token']);

        $profile = Profile::where('user_uuid', $user->user_uuid)->first();
        if (!$profile) {
            $message = 'Profile not found';

            return false;
        }

        $user->profile = $profile;

        return $user;
    }

    public function createCustomerProfile(array $data, array &$message = [])
    {
        $data['profile_uuid'] = UUIDService::generateUUID();

        //validate data against rule
        $validator = \Validator::make($data, $this->rule);

        if ($validator->fails()) {
            $message = $validator->messages()->toArray();

            return false;
        }

        $profile = new Profile();
        $profile->profile_uuid = $data['profile_uuid'];
        $profile->user_uuid = $data['user_uuid'];
        $profile->first_name = $data['first_name'];
        $profile->last_name = $data['last_name'];
        $profile->save();

        if (!$profile->save()) {
            $message = 'profile not saved';

            return false;
        }

        return $profile;
        //return $profile;

    }

    public function updateCustomer(array $data, array &$message = [])
    {
        //validate data against rule
        $validator = \Validator::make($data, $this->updateProfileRule);

        if ($validator->fails()) {
            $message = $validator->messages()->toArray();

            return false;
        }

        //get user from token
        $tokenUser = JWTAuth::toUser($data['token']);
        $user = User::find($tokenUser->user_uuid);

        !isset($data['firstname']) ? : $user->name = $data['firstname'];
        $user->save();

        $profile = Profile::where('user_uuid', $user->user_uuid)->first();
        if (!$profile) {
            $message = 'Profile not found';

            return false;
        }

        !isset($data['firstname']) ? : $profile->first_name = $data['firstname'];
        !isset($data['lastname']) ? : $profile->last_name = $data['lastname'];
        !isset($data['phone']) ? : $profile->phone = $data['phone'];
        !isset($data['address']) ? : $profile->address = $data['address'];
        !isset($data['country']) ? : $profile->country = $data['country'];
        !isset($data['city']) ? : $profile->city = $data['city'];
        !isset($data['image']) ? : $profile->photo = $data['image'] ;
        $profile->save();

        $user->profile;

        return $user;
    }

    public function changePwd(array $data, array &$message = [])
    {
        //validate data against rule
        $validator = \Validator::make($data, $this->changePwdRule);

        if ($validator->fails()) {
            $message = $validator->messages()->toArray();

            return false;
        }

        //get user from token
        $tokenUser = JWTAuth::toUser($data['token']);
        $user = User::find($tokenUser->user_uuid);

        if (!Hash::check($data['old_password'], $user->password)) {
            $message = 'Password not match';

            return false;
        }

        $user->password = bcrypt($data['new_password']);
        $user->save();

        return $message = 'Password successfully changed';
    }


    public function uploadPhoto(array $data, array &$message = [])
    {
        //validate data against rule
        $validator = \Validator::make($data, $this->photoRule);

        if ($validator->fails()) {
            $message = $validator->messages()->toArray();

            return false;
        }

        //get user from token
        $tokenUser = JWTAuth::toUser($data['token']);
        $user = User::find($tokenUser->user_uuid);

        $profile = Profile::where('user_uuid', $user->user_uuid)->first();
        if (!$profile) {
            $message = 'Profile not found';

            return false;
        }

        if(isset($data['photo'])){
            Storage::delete($profile->photo);
        }

        $profile->photo = $data['photo'];
        $profile->save();


        return $message = 'Image successfully uploaded';
    }

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
        $count = DB::table('users')->where('code', $randomString)->count();

        if ($count > 0) {
            $this->generateRandomString($length);
        }

        return $randomString;
    }

    public function getBizOrProfleRole(User $user)
    {

        //check if role isset and its Admin
        if (isset($user->role) && $user->role == 'Admin') {
            return $biz = Business::where('user_uuid', $user->user_uuid)->first();
        } elseif (isset($user->role) && $user->role == 'User') //check if role isset and its User
        {
            return $profile = Profile::where('user_uuid', $user->user_uuid)->first();
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
}