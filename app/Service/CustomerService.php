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
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

class CustomerService
{
    //validation rule for login
    protected $rule = [
        'email'         => 'required|email',
        'password'      => 'required|string',
        'first_name'    => 'required|string',
        'last_name'     => 'required|string'
    ];

    //validation rule for login
    protected $loginRule = [
        'email'         => 'required|email',
        'password'      => 'required|string',
    ];

    //validation rule for login
    protected $verifyRule = [
        'code'                  => 'sometimes|required|string',
        'verification_token'    => 'sometimes|required|string',
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

        if ($validator->fails())
        {
            $message = $validator->messages();

            return false;
        }

        $check = User::where('email', $data['email'])->where('verified', 0)->first();

        if($check)
        {
            Mail::to($check)->send(new SignUpVerification($check));

            $result = [
                'message' => 'verification code sent to your email'
            ];

        }elseif (User::where('email', $data['email'])->where('verified', 1)->first()){
            $message = 'user already exist';

            return false;
        }else{
            //create user
            $user = new User();
            $user->user_uuid = $data['user_uuid'];
            $user->name = $data['first_name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->code = $this->generateRandomString(6);

            //save user if not return false and message
            if(! $user->save())
            {
                $message = 'user not saved';

                return false;
            }

            //check if role exist
            $role = Role::where('name', $data['role'])->first();

            //if role doesn't exist return message
            if(! $role){
                $message = 'no role found';

                return false;
            }

            //attach user role relationship
            $user->roles()->attach($role);

            //create user profile
            $profile = new Profile();
            $profile->profile_uuid = $data['profile_uuid'];
            $profile->user_uuid = $data['user_uuid'];
            $profile->first_name = $data['first_name'];
            $profile->last_name = $data['last_name'];
            $profile->save();

            $user->profile;

            Mail::to($user)->send(new SignUpVerification($user));

            $result = [
                'message' => 'verification code sent to your email'
            ];
        }

        return $result;

    }

    public function verifyCustomer(array $data, array &$message = [])
    {
        //validate data against rule
        $validator = \Validator::make($data, $this->verifyRule);

        if ($validator->fails())
        {
            $message = $validator->messages();

            return false;
        }

        $user = User::where('code', $data['code'])->first();

        if(! $user)
        {
            $message = 'no user found';

            return false;
        }

        if (! $user->verified == 0)
        {
            $message = 'user already verified';

            return false;
        }

        $user->verified = 1;
        $user->save();

        $token = \JWTAuth::fromUser($user);

        // generate refresh token
        $config = config('jwt.refresh_ttl');
        $refreshToken = \JWTAuth::fromUser($user, [
            'exp'              => time() + $config * 60,
            'is_refresh_token' => true,
        ]);

        $user->profile;

        //login data
        $result = [
            'token'         => $token,
            'refresh_token' => $refreshToken,
            'user'          => $user
        ];

        return $result;
    }



    public function loginCustomer(array $data, array &$message = []){

        //validate data against rule
        $validator = \Validator::make($data, $this->loginRule);

        if ($validator->fails())
        {
            $message = $validator->messages();

            return false;
        }

        //set login credentials
        $credentials = ['email' => $data['email'], 'password' => $data['password']];

        if (! $token = JWTAuth::attempt($credentials))
        {
            $message = 'invalid_credentials';

            return false;
        }

        //get user from token
        $user = JWTAuth::toUser($token);

        if($user->verified == 0){
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
        if(! $user->role)
        {
            $message = 'user has no role';

            return false;
        }

        // get user business(restaurant or profile)
        $userResult = $this->getBizOrProfleRole($user);

        //check if user has no profile or business (restaurant)
        if(! $userResult)
        {
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
            'user_result'   => $userResult
        ];

        //return result
        return $result;

    }


    public function createCustomerProfile(array $data, array &$message = [])
    {
        $data['profile_uuid'] = UUIDService::generateUUID();

        //validate data against rule
        $validator = \Validator::make($data, $this->rule);

        if ($validator->fails())
        {
            $message = $validator->messages();

            return false;
        }

        $profile = new Profile();
        $profile->profile_uuid = $data['profile_uuid'];
        $profile->user_uuid = $data['user_uuid'];
        $profile->first_name = $data['first_name'];
        $profile->last_name = $data['last_name'];
        $profile->save();

        if(! $profile->save())
        {
            $message = 'profile not saved';

            return false;
        }

        return $profile;
        //return $profile;

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

        for ($i = 0; $i < $length; $i++)
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $count = DB::table('users')->where('code', $randomString)->count();

        if($count > 0)
        {
            $this->generateRandomString($length);
        }

        return $randomString;
    }

    public function getBizOrProfleRole(User $user)
    {

        //check if role isset and its Admin
        if (isset($user->role) && $user->role == 'Admin')
        {
            $biz = Business::where('user_uuid', $user->user_uuid)->first();

            return ['business' => $biz];

        }elseif (isset($user->role) && $user->role == 'User') //check if role isset and its User
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

        if(isset($user))
        {
            foreach ($user->roles as $role){
                $name = $role->name;
            }

            return $name;
        }
        return false;
    }
}