<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ← Tambahkan baris ini

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user(); // Sekarang ini valid

        return view('components.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:300',
        ]);

        $user->name = $request->name;

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