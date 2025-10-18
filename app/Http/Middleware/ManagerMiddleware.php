<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('employee')->user();
        
        if ($user && in_array($user->role, ['admin', 'manager'])) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthorized. Manager access required.'], 403);
        }
        
        return response()->view('errors.unauthorized', [], 403);
    }
}