<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlStoreRequest;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Nette\Utils\Strings;


class LinkController extends Controller
{

    public function index()
    {
        return view('links.index', [
            'links' => Link::all(),
        ]);
    }

    public function create()
    {
        return view('links.create');
    }

    public function store(UrlStoreRequest $request)

    {
        Link::query()->create([
            'Url' => $request->get('Url'),
            'UrlShortener' => Str::random(4),
        ]);
        return redirect(route('links.index'));

    }

    public function destroy(Link $link)
    {
        $link->delete();
        return redirect(route('links.index'));
    }

    public function handle(Link $link)
    {
        /*search with url shortener in database and get and redirect to link*/
        $url = Link::query()->where('UrlShortener', $link->UrlShortener)->first();
        return redirect($url->Url);
    }


}
