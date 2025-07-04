<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileVendorController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        return view('components.profilevendor', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'store_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:300',
        ]);

        // Update only editable fields
        $user->name = $request->name;
        $user->store_name = $request->store_name;
        $user->phone_number = $request->phone_number;

        // Handle profile picture
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture && \Storage::exists('public/profile_picture/' . $user->profile_picture)) {
                \Storage::delete('public/profile_picture/' . $user->profile_picture);
            }

            $file = $request->file('profile_picture');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('profile_picture', $filename, 'public');

            $user->profile_picture = $filename;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}