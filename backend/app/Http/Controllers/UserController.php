<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    function register(Request $req)
    {
        $user = new User;
        $user->firstName = $req->input('firstName');
        $user->lastName = $req->input('lastName');
        $user->email = $req->input('email');
        $user->password = Hash::make($req->input('password'));
        $user->save();
        return response()->json($user);
    }

    function login(Request $req)
    {
        $user = User::where('email', $req->email)->first();
        if (!$user || !Hash::check($req->password, $user->password)) {
            return ['error' => 'Incorrect email or password!'];
        }
        return $user;
    }

    function list(Request $req)
    {
        return User::all();
    }
}
