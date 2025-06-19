<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function create()
    {
        return view('superadmin.add_users'); // ganti sesuai nama view kamu
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
            'phone_number' => 'nullable|string',
            'role' => 'required|in:project_manager,procurement,vendor',
            'status' => 'nullable|in:active,inactive',
            'project_kode' => 'nullable|string',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'status' => $request->status,
            'project_kode' => $request->project_kode,
        ]);

        return redirect()->route('superadmin.dashboard')->with('success', 'User berhasil ditambahkan!');
    }

    // ✅ Tambahkan fungsi dashboard
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalProcurement = User::where('role', 'procurement')->count();
        $totalManager = User::where('role', 'project_manager')->count();
        $totalVendor = User::where('role', 'vendor')->count();
        $users = User::latest()->get();

        return view('superadmin.dashboardadm', compact('totalUsers', 'totalProcurement', 'totalManager', 'totalVendor', 'users'));
    }
}
