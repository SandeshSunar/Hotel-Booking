<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in and role is admin
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request); // Allow request to continue
        }

        // Otherwise, show 403 unauthorized
        abort(403, 'Unauthorized access.');
    }
}
