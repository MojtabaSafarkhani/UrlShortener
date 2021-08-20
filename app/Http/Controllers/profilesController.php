<?php

namespace App\Http\Controllers;

use App\Http\Middleware\verfyemailMiddleware;
use App\Http\Requests\updateprofileRequest;
use App\Models\User;

use Illuminate\Http\Request;



class profilesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', verfyemailMiddleware::class]);
    }

    public function index()
    {
        return view('profiles.index', [
            'user' => auth()->user(),
        ]);
    }

    public function edit()
    {

        return view('profiles.edit', [
            'user' => auth()->user(),

        ]);
    }

    public function update(updateprofileRequest $request)
    {

        auth()->user()->update([

            'email' => auth()->user()->email,
            'name' => $request->get('name'),
            'password' => bcrypt($request->get('password')),
            'email_verified_at' => auth()->user()->email_verified_at,

        ]);

        return redirect(route('profile.index'));

    }
}
