<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        return response()->json([
            'data' => [
                'user' => auth('api')->user(),
            ]
        ]);
    }
}
