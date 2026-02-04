<?php

namespace App\Listeners;

use App\Events\VerifyRegisterEvent;
use App\Jobs\OTPRegisterJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OTPRegisterListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(VerifyRegisterEvent $event): void
    {
        $user = $event->user;
        dispatch(new OTPRegisterJob($user));
    }
}
