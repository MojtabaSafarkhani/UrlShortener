<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreForgetPasswordRequest;
use App\Mail\ForgetPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
}
