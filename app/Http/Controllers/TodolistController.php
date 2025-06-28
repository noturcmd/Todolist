<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TodolistModel;
use Illuminate\Support\Facades\Auth;

class TodolistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Menampilkan semua tugas di dashboard
    public function index()
    {
        $tasks = TodolistModel::where('user_id', Auth::id())->get();

        $countNotDone = $tasks->where('status', 'Not Done')->count();
        $countDone = $tasks->where('status', 'Done')->count();
        $countLate = $tasks->where('status', 'Late')->count();

        return view('dashboard', compact('tasks', 'countNotDone', 'countDone', 'countLate'));
    }

    // Menampilkan form tambah tugas
    public function create()
    {
        return view('todolist_form'); // Gabung untuk tambah/edit
    }

    // Menyimpan data tugas ke database
    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'status' => 'required|string',
        ]);

        TodolistModel::create([
            'user_id' => Auth::user()->id,
            'task' => $request->task,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'status' => $request->status,
        ]);

        return redirect()->route('dashboard')->with('success', 'Tugas berhasil ditambahkan!');
    }

    // Menampilkan detail tugas (readonly)
    public function show($id)
    {
        $task = TodolistModel::findOrFail($id);
        return view('todolist_form', ['task' => $task, 'readonly' => true]);
    }

    // Menampilkan form edit tugas
    public function edit($id)
    {
        $task = TodolistModel::findOrFail($id);
        return view('todolist_form', compact('task'));
    }

    // Mengupdate tugas
    public function update(Request $request, $id)
    {
        $request->validate([
            'task' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'deadline' => 'nullable|date',
        ]);

        $task = TodolistModel::findOrFail($id);
        $task->update($request->all());

        return redirect()->route('dashboard')->with('success', 'Tugas berhasil diperbarui!');
    }

    // Menghapus tugas
    public function destroy($id)
    {
        $task = TodolistModel::findOrFail($id);
        $task->delete();

        return redirect()->route('dashboard')->with('success', 'Tugas berhasil dihapus!');
    }
}
