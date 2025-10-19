<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('employee')->user();
        
        if ($user && $user->role === 'superadmin') {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthorized. SuperAdmin access required.'], 403);
        }
        
        return response()->view('errors.unauthorized', [], 403);
    }
}