<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request)
    {
        $user = new User();

        $user->name = $request->get('name');

        $user->email = $request->get('email');

        $user->password = Hash::make($request->get('password'));

       $user->save();

        return response()->json([
            'data' => [
                'user' => $user,
                'message' => 'register successfully',
            ]
        ], 200);


    }
}
