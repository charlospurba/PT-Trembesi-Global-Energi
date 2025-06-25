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

        // Tambahkan status sebagai bagian dari kriteria login
        $credentials['status'] = 'active';

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            switch ($user->role) {
                case 'super_admin':
                    return redirect('/dashboard/superadmin');
                case 'procurement':
                    return redirect('/dashboard/procurement');
                case 'vendor':
                    return redirect('/dashboard/vendor');
                case 'project_manager':
                    return redirect('/dashboard/productmanager');
                default:
                    Auth::logout();
                    return redirect()->back()->withErrors(['role' => 'Invalid role']);
            }
        }

        return redirect()->back()->withErrors(['login' => 'Username, password, or status incorrect']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
