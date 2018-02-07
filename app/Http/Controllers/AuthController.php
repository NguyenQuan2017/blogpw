<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class AuthController extends Controller
{
    /**
     * api/register | post
     * register user
     */
    public function register () {
        $rules = [
            'username' => 'unique:users',
            'email' => 'unique:users'
        ];
        $input = request()->all();
        $validator = Validator::make($input, $rules);
        if($validator -> fails()) {
            return response_error([],'User not registered');
        }
        $username = request()->input('username');
        $email = request()->input('email');
        $password = bcrypt(request()->input('password'));
        $user = User::create(['username' => $username,'email' => $email, 'password' => $password]);

        return response_success([
            'users' => $user
        ],'User was registered');
    }

    /**
     * api/login | post
     * login user
     */
    public function login (Request $request) {

        $credentials = [
            'email' => request()->input('email'),
            'password' => request()->input('password')
        ];
        try {
            if(! $token = JWTAuth::attempt($credentials)) {
                return response_error([],'We cant find an account with this credentials');
            }
        } catch (JWTException $e) {
            return response_error([],'Login Failed,Please try again',500);
        }
       

        return response_success([
            'token' => $token
        ],'Login Success');
    }

    /**
     * api/logout | get
     * logout user
     */
    public function check_token () {
        return response_success([],'Token is alive');
    }
    /**
     *api/user | get
     * get user
     */
    public function getUser() {
        $user = JWTAuth::parseToken()->toUser();

        return response_success([
            'user' => $user
        ]);
    }

    public function getIP(Request $request) {
        $user = JWTAuth::parseToken()->authenticate();
        $history = new History();
        $history->user_id = $user->id;
        $history->ip_address =$request->ip();
        $history->save();

        return response_success([
            'histories' => $history
        ]);
    }
}
