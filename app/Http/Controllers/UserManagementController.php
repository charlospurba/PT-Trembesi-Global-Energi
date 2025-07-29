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
            'project_name' => 'nullable|string',
            'role' => 'required|in:project_manager,procurement,vendor',
            'status' => 'nullable|in:active,inactive',
            'procurement_kode' => 'nullable|string',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'project_name'  => $request->project_name,
            'role' => $request->role,
            'status' => $request->status,
            'procurement_kode' => $request->procurement_kode,
        ]);

        return redirect()->route('superadmin.dashboard')->with('success', 'User berhasil ditambahkan!');
    }

    // ✅ Tambahkan fungsi dashboard
    public function dashboard()
    {
        // Untuk tabel: status = active OR approved
        $users = User::whereIn('status', ['active', 'inactive', 'approved'])->latest()->get();

        // Untuk count: hanya status = active
        $totalUsers = User::where('status', 'active')->count();
        $totalProcurement = User::where('status', 'active')->where('role', 'procurement')->count();
        $totalManager = User::where('status', 'active')->where('role', 'project_manager')->count();
        $totalVendor = User::where('status', 'active')->where('role', 'vendor')->count();

        return view('superadmin.dashboardadm', compact(
            'totalUsers',
            'totalProcurement',
            'totalManager',
            'totalVendor',
            'users'
        ));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('superadmin.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $user->status = $request->status;
        $user->save();

        return redirect()->route('superadmin.dashboard')->with('success', 'User status berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('superadmin.dashboard')->with('success', 'User berhasil dihapus.');
    }

}