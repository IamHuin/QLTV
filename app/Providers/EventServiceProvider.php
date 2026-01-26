<?php

namespace App\Providers;

use App\Events\PostCreateEvent;
use App\Listeners\PostNotiListener;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PostCreateEvent::class, PostNotiListener::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
