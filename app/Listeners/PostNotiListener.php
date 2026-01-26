<?php

namespace App\Listeners;

use App\Events\PostCreateEvent;
use App\Jobs\NotiJob;
use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PostNotiListener
{

    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     */
    public function handle(PostCreateEvent $event)
    {
        $post = $event->post;
        dispatch(new NotiJob($post));
    }
}
