<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Cek jika status bukan 'active'
            if ($user->status !== 'active') {
                Auth::logout();

                return redirect()->route('login.form')->withErrors([
                    'inactive' => 'Your account has been deactivated. Please contact administrator.'
                ]);
            }
        }

        return $next($request);
    }
}
