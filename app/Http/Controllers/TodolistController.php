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

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // Menyimpan data tugas ke database
    public function store(Request $request)
    {
        //dd(Auth::user());
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'deadline' => 'nullable|date',
            'status' => 'required|string',
        ]);

        TodolistModel::create([
            'user_id' => Auth::user()->id,
            'task' => $request->judul,
            'description' => $request->deskripsi,
            'deadline' => $request->deadline,
            'status' => $request->status, // default status
        ]);

        return redirect()->route('dashboard')->with('success', 'Tugas berhasil ditambahkan!');
    }

    // Menampilkan semua tugas di dashboard
<<<<<<< HEAD
public function index()
{
    $tasks = TodolistModel::where('user_id', Auth::id())->get();

    // (opsional, untuk chart nanti)
    $countNotDone = $tasks->where('status', 'Not Done')->count();
    $countDone = $tasks->where('status', 'Done')->count();
    $countLate = $tasks->where('status', 'Late')->count();

    return view('dashboard', compact('tasks', 'countNotDone', 'countDone', 'countLate'));
}

// Menampilkan detail tugas
public function show($id)
{
    $task = TodolistModel::findOrFail($id);
    return view('todolist.show', compact('task'));
}

// Menampilkan form edit tugas
public function edit($id)
{
    $task = TodolistModel::findOrFail($id);
    return view('todolist.edit', compact('task'));
}

// Update data tugas
public function update(Request $request, $id)
{
    $request->validate([
        'task' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status' => 'required',
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

public function create() {
    return view('todolist_form');
}

public function edit($id) {
    $task = TodolistModel::findOrFail($id);
    return view('todolist_form', compact('task'));
}

public function show($id) {
    $task = TodolistModel::findOrFail($id);
    return view('todolist_form', ['task' => $task, 'readonly' => true]);
}
=======
    public function index()
    {
        $tasks = TodolistModel::where('user_id', Auth::id())->get();
        return view('dashboard', compact('tasks'));
    }
>>>>>>> 91e830efe4bb021466a9363e8ff0c0bbab8d097f

}
