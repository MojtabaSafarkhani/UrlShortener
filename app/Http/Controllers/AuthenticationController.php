<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SigninRequest;
use App\Http\Requests\verifyRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;


class AuthenticationController extends Controller
{
    public function user_create()
    {

        return view('authentication.signin');
    }

    public function user_store(SigninRequest $request)
    {

        $user = User::query()->create([

            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        auth()->login($user);

        return redirect(route('user.verifyemail'));
    }

    public function verifyemail()
    {

        return view('authentication.verifyemail');

    }


    public function verifyemail_store(verifyRequest $request)
    {

        $code = session()->get('code');/*get code from session where in UserObserver the code created */

        if (Hash::check($request->get('code'), $code)) {

            $user = auth()->user();

            $user->update([

                'email' => $user->email,
                'password' => $user->password,
                'email_verified_at' => Carbon::now('Asia/Tehran'),
            ]);

            return redirect(route('welcome'));

        } else {

            return redirect()->back()->withErrors(['wrong' => 'the code is wrong']);
        }
    }


    public function user_login()
    {
        return view('authentication.login');
    }

    public function user_check_login(LoginRequest $request)
    {

        $user = User::query()->where('email', $request->get('email'))->first();

        if (!Hash::check($request->get('password'), $user->password)) {

            return redirect()->back()->withErrors(['error' => 'email or password is wrong']);

        } else {

            if ($request->has('remember_me')) {

                Cookie::queue('email', $request->get('email'), 86400);

                Cookie::queue('password', $request->get('password'), 86400);
            } else {

                Cookie::queue('email', '');

                Cookie::queue('password', '');
            }

            auth()->login($user);

            session()->flash('success', 'login successfully');

            return redirect(route('welcome'));
        }
    }

    public function logout()
    {
        auth()->logout();

        return redirect(route('welcome'));
    }


}
