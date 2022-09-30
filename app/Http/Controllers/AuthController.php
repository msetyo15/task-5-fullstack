<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);
        try {
            $user = User::where('email', $request->email)->first();
            if (!$user) return response(['status' => false, 'message' => 'User not found!']);
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken($user->name)->accessToken;
                return response([
                    'status' => true,
                    'message' => [
                        'user' => $user,
                        'token' => $token
                    ]
                    ]);
            }
            else {
                return response(['status' => false, 'message' => 'Wronk password!']);
            }
        } catch (\Throwable $th) {
            return response(['status' => false, 'message' => $th->getMessage()]);
        }
    }
}
