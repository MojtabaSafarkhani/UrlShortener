<?php

namespace App\Http\Controllers;

use App\Http\Middleware\verfyemailMiddleware;
use App\Http\Requests\UrlStoreRequest;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Nette\Utils\Strings;


class LinksController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth',verfyemailMiddleware::class]);
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

    public function store(UrlStoreRequest $request)

    {
        $slug = Str::random(4);

        $is_slug_used = Link::query()->where('slug', $slug)->exists();


        if ($is_slug_used) {

            return redirect()->back()->withErrors(['wrong' => 'something is wrong please try again!']);

        } else {
            Link::query()->create([

                'url' => $request->get('url'),
                'slug' => $slug,
                'user_id' => auth()->id(),
            ]);

            return redirect(route('links.index'));
        }


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
