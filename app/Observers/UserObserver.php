<?php

namespace App\Observers;

use App\Mail\Verifyemail;
use App\Models\user;
use Illuminate\Support\Facades\Mail;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param \App\Models\user $user
     * @return void
     */
    public function created(user $user)
    {
        $code = random_int(1111, 9999);

        session()->put(['code' => bcrypt($code)]);

        Mail::to($user->email)->send(new Verifyemail($code));
    }

    /**
     * Handle the user "updated" event.
     *
     * @param \App\Models\user $user
     * @return void
     */
    public function updated(user $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param \App\Models\user $user
     * @return void
     */
    public function deleted(user $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param \App\Models\user $user
     * @return void
     */
    public function restored(user $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param \App\Models\user $user
     * @return void
     */
    public function forceDeleted(user $user)
    {
        //
    }
}
