<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        // Skip middleware for public routes
        $publicRoutes = ['login', 'register', 'register-detail', 'signin', 'signup', 'signup/form', 'store', 'store/product/*'];
        foreach ($publicRoutes as $route) {
            if ($request->is($route)) {
                return $next($request);
            }
        }

        // Check if user is authenticated
        if (!Auth::check()) {
            Log::warning('Unauthenticated access attempt', [
                'url' => $request->url(),
                'ip' => $request->ip(),
            ]);
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated. Please log in.'
                ], 401);
            }
            return redirect()->route('login.form')->withErrors(['login' => 'Please log in to continue.']);
        }

        $user = Auth::user();
        // Check user status
        if ($user->status !== 'active') {
            Log::warning('Inactive user attempt', [
                'user_id' => $user->id,
                'url' => $request->url(),
            ]);
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your account is not active. Please contact the administrator.'
                ], 403);
            }
            return redirect()->route('login.form')->withErrors(['status' => 'Your account is not active. Please contact the administrator.']);
        }

        return $next($request);
    }
}