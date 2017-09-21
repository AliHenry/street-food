<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthenticateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //get token from header
        $token = $request->get('token', $request->header('token'));

        //check if token set
        if (! $token) {
            return [
                'error' => 'Token is required',
            ];
        }

        try {
            //get user from token
            $user = \JWTAuth::toUser($token);

            //check if user is set
            if (! $user) {
                return [
                    'error' => 'user_not_found',
                ];
            }

            //get route action
            $sections = $request->route()->getAction();
            //get roles from route action
            $roles = isset($sections['roles']) ? $sections['roles'] : null;

            //check if user has role
            if(! $user->hasAnyRole($roles)){
                return ['error' => 'unauthorized user',];
            }


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
            \Log::error($e);

            return [
                'error' => 'token_absent',
            ];
        }

        return $next($request);
    }
}
