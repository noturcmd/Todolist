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
    public function index(Request $request)
    {
        $query = TodolistModel::where('user_id', Auth::id());

        // Filter Status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Filter Deadline
        if ($request->has('deadline') && $request->deadline != 'all') {
            if ($request->deadline == 'today') {
                $query->whereDate('deadline', now()->toDateString());
            } elseif ($request->deadline == 'week') {
                $query->whereBetween('deadline', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($request->deadline == 'month') {
                $query->whereMonth('deadline', now()->month);
            }
        }

        // Filter Keyword (Search by task name or description)
        if ($request->has('keyword') && $request->keyword != '') {
            $query->where(function ($q) use ($request) {
                $q->where('task', 'like', '%' . $request->keyword . '%')
                ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }

        // Sort
        if ($request->has('sort')) {
            if ($request->sort == 'latest') {
                $query->orderBy('created_at', 'desc');
            } elseif ($request->sort == 'oldest') {
                $query->orderBy('created_at', 'asc');
            } elseif ($request->sort == 'deadline_asc') {
                $query->orderBy('deadline', 'asc');
            } elseif ($request->sort == 'deadline_desc') {
                $query->orderBy('deadline', 'desc');
            }
        }

        $tasks = $query->get();

        // Chart Count (tetap jalan seperti biasa)
        $countNotDone = TodolistModel::where('user_id', Auth::id())->where('status', 'Not Done')->count();
        $countDone = TodolistModel::where('user_id', Auth::id())->where('status', 'Done')->count();
        $countLate = TodolistModel::where('user_id', Auth::id())->where('status', 'Late')->count();

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
