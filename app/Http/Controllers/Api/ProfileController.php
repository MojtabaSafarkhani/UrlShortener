<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        return response()->json([
            'data' => [
                'user' => auth('api')->user(),
            ]
        ]);
    }

    /**
     * @param UpdateProfileRequest $request
     * @var User $user
     */
    public function update(UpdateProfileRequest $request)
    {

        $user = auth('api')->user();

        $user->update([

            'name' => $request->get('name', $user->name),
            'email' => $request->get('email', $user->email),
            'password' => Hash::make($request->get('password', $user->password)),

        ]);

        return response()->json([

            'data' => [
                'user' => $user,
                'message' => 'update successfully'
            ]

        ]);

    }
}
