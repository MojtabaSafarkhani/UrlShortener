<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgetEmailRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Mail\ForgetPasswordMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgetPasswordController extends Controller
{
    public function create()
    {
        return view('forget-password.create');
    }

    public function store(ForgetEmailRequest $request)
    {
        $email = $request->get('email');

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        Mail::to($email)->send(new ForgetPasswordMail($token));

        return redirect()->back()->withErrors(['successful' => 'check your email and click on link']);
    }

    public function reSetPassword($token)
    {
        return view('forget-password.reset', [
            'token' => $token,
        ]);
    }

    public function reSetPasswordStore(ResetPasswordRequest $request, $token)
    {
        $email = $request->get('email');

        $is_email_exists = DB::table('password_resets')->where([
            'email' => $email,
            'token' => $token,
        ])->exists();

        if (!$is_email_exists) {

            return redirect()->back()->withErrors(['errors' => 'something is wrong']);

        } else {

            User::query()->where('email', $email)->update(['password' => Hash::make($request->get('password'))]);

            DB::table('password_resets')->where('email', $email)->delete();

            return redirect(route('login.create'));
        }


    }
}
