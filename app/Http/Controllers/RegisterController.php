<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register'); // Pastikan file Blade ini ada
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|max:20',
            'npwp' => 'required|string|max:30',
            'username' => 'required|string|max:50|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nib' => 'required|string|max:50',
            'comp_profile' => 'required|file|mimes:pdf,doc,docx',
            'izin_perusahaan' => 'required|file|mimes:pdf,doc,docx',
            'sppkp' => 'required|file|mimes:pdf,doc,docx',
            'struktur_organisasi' => 'required|file|mimes:pdf,doc,docx',
            'daftar_pengalaman' => 'required|file|mimes:pdf,doc,docx',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Upload dokumen ke disk 'public'
        $comp_profile = $request->file('comp_profile')->store('vendor_docs', 'public');
        $izin_perusahaan = $request->file('izin_perusahaan')->store('vendor_docs', 'public');
        $sppkp = $request->file('sppkp')->store('vendor_docs', 'public');
        $struktur_organisasi = $request->file('struktur_organisasi')->store('vendor_docs', 'public');
        $daftar_pengalaman = $request->file('daftar_pengalaman')->store('vendor_docs', 'public');

        $user = User::create([
            'store_name' => $request->store_name,
            'name' => $request->store_name, //sekaligus isi kolom name
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'npwp' => $request->npwp,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nib' => $request->nib,
            'comp_profile' => $comp_profile,
            'izin_perusahaan' => $izin_perusahaan,
            'sppkp' => $sppkp,
            'struktur_organisasi' => $struktur_organisasi,
            'daftar_pengalaman' => $daftar_pengalaman,
            'role' => 'vendor',
            'status' => 'pending',
        ]);


        // Optional: Langsung login setelah register
        auth()->login($user);

        return redirect()->route('vendor.registration_status');
    }
}
