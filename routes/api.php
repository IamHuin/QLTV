<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

Route::post('register', [UserController::class, 'register'])->name('api.register');
Route::post('login', [UserController::class, 'login'])->name('api.login');

Route::middleware('auth:api')->group(function () {
    Route::middleware('role:1')->group(function () {
        //User
        Route::get('user', [UserController::class, 'index'])->name('user.index');
        Route::post('user', [UserController::class, 'find'])->name('user.find');
        Route::delete('user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
        //Group
        Route::patch('group/{group}', [GroupController::class, 'update'])->name('group.update');
        Route::post('group', [GroupController::class, 'store'])->name('group.store');
        Route::delete('group/{group}', [GroupController::class, 'destroy'])->name('group.destroy');
        //PermissionController
        Route::get('permission', [PermissionController::class, 'index'])->name('permission.index');
        Route::post('permission', [PermissionController::class, 'store'])->name('permission.store');
        Route::patch('permission/{permission}', [PermissionController::class, 'update'])->name('permission.update');
        Route::delete('permission/{permission}', [PermissionController::class, 'destroy'])->name('permission.destroy');
        Route::post('auth', [AuthController::class, 'store'])->name('auth.store');
        //Mail
        Route::get('mail', [MailController::class, 'sendMail'])->name('mail.sendMail');
    });
    Route::post('logout', [UserController::class, 'logout'])->name('api.logout');
    //User
    Route::middleware('permission:manageUser')->group(function () {
        Route::get('user/{user}', [UserController::class, 'show'])->name('user.show');
        Route::patch('user/{user}', [UserController::class, 'update'])->name('user.update');
    });

    Route::middleware('role:2')->group(function () {
        Route::get('profile/{profile}', [ProfileController::class, 'show'])->name('profile.show');
        Route::patch('profile/{profile}', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('group/{group}', [GroupController::class, 'join'])->name('group.join');
    });
    //Post
    Route::middleware('permission:managePost')->group(function () {
        Route::get('post', [PostController::class, 'index'])->name('post.index');
        Route::get('post/{post}', [PostController::class, 'show'])->name('post.show');
        Route::patch('post/{post}', [PostController::class, 'update'])->name('post.update');
        Route::post('post', [PostController::class, 'store'])->name('post.store');
        Route::delete('post/{post}', [PostController::class, 'destroy'])->name('post.destroy');
    });
    //Group
    Route::middleware('permission:manageGroup')->group(function () {
        Route::get('group', [GroupController::class, 'index'])->name('group.index');
        Route::get('group/{group}', [GroupController::class, 'show'])->name('group.show');
    });
});
