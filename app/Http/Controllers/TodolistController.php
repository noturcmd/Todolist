<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TodolistController extends Controller
{
     public function create()
    {
        return view('add_todolist');
    }

    public function store(Request $request)
{
    // Validasi form
    $request->validate([
        'title' => 'required|string|max:255',
        'deadline' => 'required|date',
        'status' => 'required|in:todo,inprogress,done,late',
    ]);

    // Simpan tugas ke database (jika sudah punya model Todolist)
    \App\Models\Todolist::create([
        'title' => $request->title,
        'deadline' => $request->deadline,
        'status' => $request->status,
    ]);

    return redirect()->route('todolist.create')->with('success', 'Tugas berhasil ditambahkan!');
}

}
