<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateLinkRequest;
use App\Http\Resources\LinkResource;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    public function store(CreateLinkRequest $request)
    {
        do {

            $slug = Str::random(4);

            $is_slug_used = Link::query()->where('slug', $slug)->exists();


        } while ($is_slug_used);


        $link = new Link();

        $link->url = $request->get('url');

        $link->slug = $slug;

        $link->user_id = auth()->id();

        $link->save();

        return response()->json([

            'data' => [

                'link' => new LinkResource($link->load('user')),

            ]
        ]);

    }
}
