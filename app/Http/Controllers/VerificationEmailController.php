<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerificationEmailController extends Controller
{
    public function show()

    {
        if (!auth()->user()->hasVerifiedEmail()) {

            return view('verify-email.verifyEmails');

        } else {

            return redirect()->back();
        }

    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect(route('welcome'));

    }

    public function notify(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->withErrors('message', 'Resend Verify');
    }
}
