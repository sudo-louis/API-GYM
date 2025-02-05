<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('sanctum')->check()) {
            return response()->json(['message' => 'No autorizado'], 401);
        }

        return $next($request);
    }
}
