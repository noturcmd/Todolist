<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\LogActivity;


class UserController extends Controller
{
    public function showProfile()
    {
        return view('profile_page'); // ini file blade tampilan profil nanti
    }

    public function update(Request $request)
    {
        // Mendapatkan pengguna yang sedang login
        $user = Auth::user();

        // Cek data yang diterima
        Log::info('Data yang diterima untuk update:', $request->all());
//        dd($request->all()); // Ini akan menghentikan eksekusi dan menampilkan data

        // Validasi input dari pengguna
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed', // Password hanya diperlukan jika ingin mengganti
        ]);

        // Update nama dan email
        $user->name = $request->name;
        $user->email = $request->email;

        // Jika password diisi, maka kita hash dan simpan
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

//        dd($user);

        // Simpan perubahan
        $user->save();

        // Log perubahan yang berhasil disimpan
        Log::info('User profile updated:', ['user' => $user]);

        LogActivity::create([
            'user_id' => $user->id,
            'activity' => 'Memperbarui profil',
        ]);
        
        // Redirect kembali ke halaman profil dengan pesan sukses
        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }




}
