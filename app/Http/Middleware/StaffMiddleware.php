<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('employee')->user();
        
        if ($user && in_array($user->role, ['admin', 'manager', 'staff'])) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthorized. Staff access required.'], 403);
        }
        
        return response()->view('errors.unauthorized', [], 403);
    }
}