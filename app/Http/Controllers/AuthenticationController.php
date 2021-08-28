<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\True_;

class AuthenticationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('destroy');

    }

    public function create()
    {
        return view('authentication.create');
    }

    public function store(LoginRequest $request)
    {

        $remember = $request->has('remember_me');

        if (Auth::attempt(['email' => $request->get('email'),
            'password' => $request->get('password')], $remember)) {

            $user = auth()->user();

            auth()->login($user);

            if (!$user->hasVerifiedEmail()) {

                return redirect(route('verification.notice'));

            } else {

                return redirect(route('welcome'));
            }
        } else {

            return redirect()->back()->withErrors(['error' => 'email or password is wrong']);
        }
    }

    public function destroy()
    {
        auth()->logout();

        return redirect(route('welcome'));
    }
}
