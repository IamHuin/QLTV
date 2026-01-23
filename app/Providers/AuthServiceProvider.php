<?php

namespace App\Providers;

use App\Models\Group;
use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use App\Policies\GroupPolicy;
use App\Policies\PostPolicy;
use App\Policies\ProfilePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class  => UserPolicy::class,
        Profile::class => ProfilePolicy::class,
        Post::class => PostPolicy::class,
        Group::class => GroupPolicy::class,
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        $this->registerPolicies();
    }
}
