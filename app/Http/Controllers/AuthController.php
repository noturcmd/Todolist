<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login_page');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Simpan email ke sesi (opsional)
            $request->session()->put("user", $request->input("email"));

            // Buat cookie: nama = user_email, isi = email login, durasi = 60 menit
            $cookie = cookie('user_email', $request->input('email'), 60);

            // Redirect ke dashboard dengan cookie
            return redirect()->intended('/dashboard')->withCookie($cookie);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    public function showRegisterForm()
    {
        return view('register_page');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('login.form')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function dashboard(Request $request)
    {
        // Cek apakah ada cookie user_email
        if (!$request->cookie('user_email')) {
            return redirect('/login')->with('error', 'Sesi tidak ditemukan. Silakan login kembali.');
        }

        return view('dashboard'); // Ganti dengan view dashboard kamu
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Hapus cookie dengan membuat cookie bernama sama dan waktu kadaluarsa 0
        $forgetCookie = cookie()->forget('user_email');

        return redirect('/login')->withCookie($forgetCookie);
    }
}
