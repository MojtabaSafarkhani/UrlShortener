<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LinksController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => [
                'links' => auth('api')->user()->links
            ]
        ]);
    }
}
