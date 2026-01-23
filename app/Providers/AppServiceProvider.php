<?php

namespace App\Providers;

use App\Reposiroty\Contract\AuthRepositoryInterface;
use App\Reposiroty\Contract\GroupRepositoryInterface;
use App\Reposiroty\Contract\PermissionRepositoryInterface;
use App\Reposiroty\Contract\PostRepositoryInterface;
use App\Reposiroty\Contract\ProfileRepositoryInterface;
use App\Reposiroty\Contract\UserRepositoryInterface;
use App\Reposiroty\Eloquent\AuthRepository;
use App\Reposiroty\Eloquent\GroupRepository;
use App\Reposiroty\Eloquent\PermissionRepository;
use App\Reposiroty\Eloquent\PostRepository;
use App\Reposiroty\Eloquent\ProfileRepository;
use App\Reposiroty\Eloquent\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(GroupRepositoryInterface::class, GroupRepository::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
