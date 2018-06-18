<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {

        $permission = trim($permission);

        if (!Auth::check() || !Auth::user() || Auth::user()->hasPermission($permission) === false) {
            return response()->json(['error' => 'You have no permission to access this page.'], 403);
        }

        return $next($request);

    }
}
