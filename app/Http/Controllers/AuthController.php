<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\LogActivity;


class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('login_page');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            LogActivity::create([
                'user_id' => auth()->id(),
                'activity' => 'Login',
            ]);
            // Redirect berdasarkan role
            if ($user->hasRole('admin')) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('dashboard');
            }
        }
        
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    // Menampilkan halaman register
    public function showRegisterForm()
    {
        return view('register_page');
    }

    // Proses registrasi
    // Proses registrasi
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

        LogActivity::create([
            'user_id' => $user->id,
            'activity' => 'Registrasi pengguna baru',
        ]);

        // Auto assign role 'admin' kalau email-nya tertentu
        if ($user->email === 'admin@example.com') {
            $user->assignRole('admin');
        } else {
            $user->assignRole('user');
        }

        return redirect()->route('login.form')->with('success', 'Registrasi berhasil! Silakan login.');
    }


    // Optional: Halaman dashboard gabungan
    public function dashboard()
    {
        $user = Auth::user();
        $userName = $user->name;
        
        return view('dashboard', compact('userName'));
    }

    // Logout
    public function logout(Request $request)
    {
        LogActivity::create([
            'user_id' => auth()->id(),
            'activity' => 'Logout',
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
