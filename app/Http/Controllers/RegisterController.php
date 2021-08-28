<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterStoreRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register.create');
    }

    public function store(RegisterStoreRequest $request)
    {
        $user = new User();

        $user->name = $request->get('name');

        $user->email = $request->get('email');

        $user->password = Hash::make($request->get('password'));

        $user->save();

        event(new Registered($user));

        return redirect(route('login.create'));
    }
}
