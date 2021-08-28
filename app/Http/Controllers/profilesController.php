<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class ProfilesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function show(User $user)
    {
        return view('profile.show', [
            'user' => $user,
        ]);
    }

    public function edit(User $user)
    {
        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    public function update(UpdateProfileRequest $request)
    {
        $email_at_db = auth()->user()->email;

        $email = $request->get('email');

        $is_email_used = User::where('email', $email)
            ->where('id', '!=', auth()->id())->exists();

        if (!$is_email_used) {

            auth()->user()->update([

                'name' => $request->get('name'),
                'email' => $email,
                'password' => Hash::make($request->get('password')),
                'email_verified_at' => $this->checkVerify($email_at_db, $email),
            ]);

            if ($this->checkVerify($email_at_db, $email) == null) {

                event(new Registered(auth()->user()));

                return redirect(route('verification.notice'));
            }

            return redirect(route('profile.show', auth()->user()));

        } else {
            return redirect()->back()->withErrors(['error' => 'email must be unique']);
        }

    }

    public function checkVerify($email_at_db, $email)
    {
        return ($email_at_db != $email) ? NULL : auth()->user()->email_verified_at;
    }
}
