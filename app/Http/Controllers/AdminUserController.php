<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TodolistModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LogActivity;

class AdminUserController extends Controller
{
    public function index(Request $request)
{
    // Ambil daftar user (dengan pencarian opsional)
    $query = User::query();

    if ($request->search) {
        $query->where('name', 'like', "%{$request->search}%")
              ->orWhere('email', 'like', "%{$request->search}%");
    }

    $users = $query->get();

    // Hitung statistik todolist user yang sedang login
    $countNotDone = TodolistModel::where('user_id', Auth::id())
        ->where('status', 'Not Done')
        ->count();

    $countDone = TodolistModel::where('user_id', Auth::id())
        ->where('status', 'Done')
        ->count();

    $countLate = TodolistModel::where('user_id', Auth::id())
        ->where('status', 'Late')
        ->count();

    $userName = Auth::user()->name;

    // Kirim ke view
    return view('admin.users.index', compact(
        'users',
        'countNotDone',
        'countDone',
        'countLate',
        'userName'
    ));
}


    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->syncRoles($request->role);

        LogActivity::create([
            'user_id' => auth()->id(),
            'activity' => "Mengubah role user dengan ID {$user->id} menjadi {$request->role}",
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Role diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->id == auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        LogActivity::create([
            'user_id' => auth()->id(),
            'activity' => "Menghapus user dengan ID {$user->id} ({$user->email})",
        ]);

        return redirect()->back()->with('success', 'User dihapus!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:user,admin',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole($request->role);

        LogActivity::create([
            'user_id' => auth()->id(),
            'activity' => "Menambahkan user baru: {$user->name} ({$user->email}) dengan role {$request->role}",
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan!');
    }

}
