<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login'); // nama file blade kamu
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        // Cek user berdasarkan username (tanpa filter status dulu)
        $user = \App\Models\User::where('username', $credentials['username'])->first();

        if (!$user) {
            return redirect()->back()->withErrors(['login' => 'User not found']);
        }

        if (!Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            return redirect()->back()->withErrors(['login' => 'Password incorrect']);
        }

        // Login sukses
        $user = Auth::user();

        switch ($user->role) {
            case 'super_admin':
                return redirect('/dashboard/superadmin');

            case 'procurement':
                return redirect('/dashboard/procurement');

            case 'project_manager':
                return redirect('/dashboard/productmanager');

            case 'vendor':
                // Kalau belum active, arahkan ke status
                if ($user->status !== 'active') {
                    return redirect()->route('vendor.registration_status');
                }

                return redirect('/dashboard/vendor');

            default:
                Auth::logout();
                return redirect()->back()->withErrors(['role' => 'Invalid role']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
