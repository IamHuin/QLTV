<?php

namespace App\Providers;

use App\Events\PostCreateEvent;
use App\Events\RegisterEvent;
use App\Listeners\NotiMailRegisterListener;
use App\Listeners\PostNotiListener;
use App\Listeners\VerifyMailRegisterListener;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PostCreateEvent::class, PostNotiListener::class);
        $this->app->bind(RegisterEvent::class, VerifyMailRegisterListener::class);
        $this->app->bind(RegisterEvent::class, NotiMailRegisterListener::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
