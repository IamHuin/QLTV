<?php

namespace App\Listeners;

use App\Events\NotiRegisterEvent;
use App\Jobs\MailRegisterJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MailRegisterListener
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
    public function handle(NotiRegisterEvent $event): void
    {
        $user = $event->user;
        dispatch(new MailRegisterJob($user));
    }
}
