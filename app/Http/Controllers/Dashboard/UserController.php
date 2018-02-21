<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;
use Auth;
use Crypt;

class UserController extends Controller
{
    public function getAllUser() {
        $users  = User::all();

        return response_success([
            'users' => $users
        ],'Get All User');
    }

    public function getPassword($id) {
        $user = User::find($id);
        return response_success([
            'password' => Crypt::decrypt($user->password)
        ],'Get password');
    }
}
