<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function store(LoginRequest $request)
    {

        if (!Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {

            return response()->json([
                'data' => [
                    'message' => 'email or password is wrong',
                ]
            ]);
        }
        $user = User::query()->where('email', $request->get('email'))->first();


        $token = $user->generateToken();


        return response()->json([
            'data' => [
                'token' => $token,
            ]
        ], 200);


    }

    public function destroy()
    {

        auth('api')->user()->clearToken();

        return response()->json([
            'data' => [
                'message' => 'logout successfully'
            ]
        ]);
    }
}
