<?php

namespace App\Http\Controllers;


use App\Http\Requests\UrlRequest;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Nette\Utils\Strings;


class LinksController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }


    public function index()
    {
        return view('links.index', [
            'links' => auth()->user()->links,
        ]);
    }

    public function create()
    {
        return view('links.create');
    }

    public function store(UrlRequest $request)

    {
        do {
            $slug = Str::random(64);

            $is_slug_used = Link::query()->where('slug', $slug)->exists();


        } while ($is_slug_used);


        $link = new Link();

        $link->url = $request->get('url');

        $link->slug = $slug;

        $link->user_id = auth()->id();

        $link->save();

        return redirect(route('links.index'));


    }

    public function destroy(Link $link)
    {
        $link->delete();

        return redirect(route('links.index'));
    }

    public function handle(Link $link)
    {

        return redirect($link->url);
    }


}
