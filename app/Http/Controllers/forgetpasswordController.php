<?php

namespace App\Http\Controllers;

use App\Http\Requests\checkEmailRequest;
use App\Http\Requests\save_passwordRequest;
use App\Mail\forgetpassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Self_;

class forgetpasswordController extends Controller
{


    public function create()
    {
        return view('forgetpassword.create');
    }

    public function check(checkEmailRequest $request)
    {
        $user = User::query()->where('email', $request->get('email'))->first();

        if ($user->email_verified_at != null) /*just verified email can use forget password*/ {

            $code = random_int(1111, 9999);

            $user->update([

                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at,
                    'password' => bcrypt($code)]
            );
            $valid_email = Str::random(5);

            session()->put(['valid_email' => $valid_email]);/*create session and check in change_password method for
                                                                 sure  send an email */

            Mail::to($user->email)->send(new forgetpassword($code));

            return redirect()->route('change.password', $user);
        } else {

            return redirect()->back()->withErrors(['wrong' => 'Your email is wrong or Your email not verified']);
        }
    }

    public function change_password(User $user)
    {

        if (session()->has('valid_email')) {

            return view('forgetpassword.change_password', [
                'user' => $user,
            ]);

        } else {

            return redirect(route('forget.create'))->withErrors(['wrong' => 'your action is invalid']);
        }

    }

    public function login_with_forget_password(save_passwordRequest $request, User $user)
    {


        if (!Hash::check($request->get('password'), $user->password)) {

            return redirect()->back()->withErrors(['error' => 'your code is wrong']);

        } else {

            auth()->login($user);

            session()->remove('valid_email');

            session()->flash('success', 'login successfully');

            return redirect(route('welcome'));
        }


    }
}
