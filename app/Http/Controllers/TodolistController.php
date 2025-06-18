<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TodolistModel;
use Illuminate\Support\Facades\Auth;

class TodolistController extends Controller
{
    // Menampilkan form tambah tugas
    public function create()
    {
        return view('add_todolist');
    }

    // Menyimpan data tugas ke database
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'deadline' => 'nullable|date',
        ]);

        TodolistModel::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline,
            'status' => 'todo', // default status
        ]);

        return redirect()->route('dashboard')->with('success', 'Tugas berhasil ditambahkan!');
    }

    // Menampilkan semua tugas di dashboard
    public function index()
    {
        $tasks = TodolistModel::where('id', Auth::id())->get();
        return view('dashboard', compact('tasks'));
    }
}
