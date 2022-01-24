<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Http\Requests\Api\StoreForgetPasswordRequest;
use App\Mail\ForgetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgetPasswordController extends Controller
{
    public function store(StoreForgetPasswordRequest $request)
    {

        $email = $request->get('email');

        $token = Str::random(64);

        DB::table('password_resets')->insert([

            'email' => $email,
            'token' => $token,
        ]);

        return response()->json([
            'data' => [
                'token' => $token,
            ]
        ]);

    }

    public function passwordReset(ResetPasswordRequest $request)
    {
        $email = $request->get('email');

        $isRowExists = DB::table('password_resets')->where([

            'email' => $email,

            'token' => $request->get('token'),
        ])->exists();

        if (!$isRowExists) {

            return response()->json([

                'data' => [
                    'success' => 'false',
                    'errors' => 'something is wrong!!!'
                ]

            ]);
        }

        User::query()->where('email', $email)->update([
            'password' => Hash::make($request->get('password')),
        ]);

        DB::table('password_resets')->where('email', $email)->delete();

        return response()->json([

            'data' => [
                'message' => 'Your password changed!',
            ]

        ]);

    }
}
