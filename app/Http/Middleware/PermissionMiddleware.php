<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        $user = $request->user();
        if (!($user->hasPermission($permission))) {
            return response()->json([
                "success" => false,
                "message" => __('Unauthorized'),
            ]);
        }
        return $next($request);
    }
}
