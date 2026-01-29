<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;

Route::post('register', [UserController::class, 'register'])->name('api.register');
Route::post('login', [UserController::class, 'login'])->name('api.login');

Route::middleware('auth:api')->group(function () {
    Route::middleware('role:1')->group(function () {
        //User
        Route::get('user', [UserController::class, 'index'])->name('user.index');
        Route::get('user/search', [UserController::class, 'search'])->name('user.search');
        Route::delete('user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
        //Group
        Route::patch('group/{id}', [GroupController::class, 'update'])->name('group.update');
        Route::post('group', [GroupController::class, 'store'])->name('group.store');
        Route::delete('group/{id}', [GroupController::class, 'destroy'])->name('group.destroy');
        //PermissionController
        Route::get('permission', [PermissionController::class, 'index'])->name('permission.index');
        Route::post('permission', [PermissionController::class, 'store'])->name('permission.store');
        Route::patch('permission/{id}', [PermissionController::class, 'update'])->name('permission.update');
        Route::delete('permission/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy');
        Route::post('auth', [AuthController::class, 'store'])->name('auth.store');
        //Mail
        Route::get('mail', [MailController::class, 'sendMail'])->name('mail.sendMail');
    });
    Route::post('logout', [UserController::class, 'logout'])->name('api.logout');
    //User
    Route::middleware('permission:manageUser')->group(function () {
        Route::get('user/{id}', [UserController::class, 'show'])->name('user.show');
        Route::patch('user/{id}', [UserController::class, 'update'])->name('user.update');
    });

    Route::middleware('role:2')->group(function () {
        Route::get('profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
        Route::patch('profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('group/{id}', [GroupController::class, 'join'])->name('group.join');
    });
    //Post
    Route::middleware('permission:managePost')->group(function () {
        Route::get('post', [PostController::class, 'index'])->name('post.index');
        Route::get('post/{id}', [PostController::class, 'show'])->name('post.show');
        Route::patch('post/{id}', [PostController::class, 'update'])->name('post.update');
        Route::put('post', [PostController::class, 'multiUpdate'])->name('post.multiUpdate');
        Route::post('post', [PostController::class, 'store'])->name('post.store');
        Route::delete('post/{id}', [PostController::class, 'destroy'])->name('post.destroy');
        Route::delete('post', [PostController::class, 'destroyMulti'])->name('post.destroyMulti');
    });
    //Group
    Route::middleware('permission:manageGroup')->group(function () {
        Route::get('group', [GroupController::class, 'index'])->name('group.index');
        Route::get('group/{id}', [GroupController::class, 'show'])->name('group.show');
    });
});
