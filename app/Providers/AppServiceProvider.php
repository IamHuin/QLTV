<?php

namespace App\Providers;

use App\Contract\PaginateInterface;
use App\Contract\TranslateInterface;
use App\Repository\Contract\AuthRepositoryInterface;
use App\Repository\Contract\GroupRepositoryInterface;
use App\Repository\Contract\ImageRepositoryInterface;
use App\Repository\Contract\LoginRepositoryInterface;
use App\Repository\Contract\PermissionRepositoryInterface;
use App\Repository\Contract\PostRepositoryInterface;
use App\Repository\Contract\ProfileRepositoryInterface;
use App\Repository\Contract\RegisterRepositoryInterface;
use App\Repository\Contract\UserRepositoryInterface;
use App\Repository\Eloquent\AuthRepository;
use App\Repository\Eloquent\GroupRepository;
use App\Repository\Eloquent\ImageRepository;
use App\Repository\Eloquent\LoginRepository;
use App\Repository\Eloquent\PermissionRepository;
use App\Repository\Eloquent\PostRepository;
use App\Repository\Eloquent\ProfileRepository;
use App\Repository\Eloquent\RegisterRepository;
use App\Repository\Eloquent\UserRepository;
use App\Service\PaginateService;
use App\Service\TranslateService;
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
        $this->app->bind(RegisterRepositoryInterface::class, RegisterRepository::class);
        $this->app->bind(LoginRepositoryInterface::class, LoginRepository::class);
        $this->app->bind(ImageRepositoryInterface::class, ImageRepository::class);
        $this->app->singleton(TranslateInterface::class, TranslateService::class);
        $this->app->singleton(PaginateInterface::class, PaginateService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
