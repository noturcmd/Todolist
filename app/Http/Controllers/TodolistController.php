<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TodolistModel;
use Illuminate\Support\Facades\Auth;
use App\Models\LogActivity;

class TodolistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Menampilkan semua tugas di dashboard
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        LogActivity::create([
            'user_id' => Auth::id(),
            'activity' => 'Mengakses halaman dashboard/todolist',
        ]);

        // Query untuk mendapatkan tugas yang dibuat hari ini oleh user yang sedang login
        $query = TodolistModel::where('user_id', Auth::id());

        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Filter deadline jika ada
        if ($request->has('deadline') && $request->deadline != 'all') {
            if ($request->deadline == 'today') {
                $query->whereDate('deadline', now()->toDateString());
            } elseif ($request->deadline == 'week') {
                $query->whereBetween('deadline', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($request->deadline == 'month') {
                $query->whereMonth('deadline', now()->month);
            }
        }

        // Filter berdasarkan keyword
        if ($request->has('keyword') && $request->keyword != '') {
            $query->where(function ($q) use ($request) {
                $q->where('task', 'like', '%' . $request->keyword . '%')
                    ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }

        // Sort data berdasarkan sort type
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

        // Ambil hasil query
        $tasks = $query->get();

        // Hitung jumlah tugas berdasarkan status
        $countNotDone = TodolistModel::where('user_id', Auth::id())
            ->where('status', 'Not Done')
            ->count();

        $countDone = TodolistModel::where('user_id', Auth::id())
            ->where('status', 'Done')
            ->count();

        $countLate = TodolistModel::where('user_id', Auth::id())
            ->where('status', 'Late')
            ->count();

        // Kirim data tugas ke view
        $userName = Auth::user()->name;  // Get the authenticated user's name
        return view('dashboard', compact('tasks', 'countNotDone', 'countDone', 'countLate', 'userName'));
    }


    // Menampilkan form tambah tugas
    public function create()
    {
        LogActivity::create([
            'user_id' => Auth::id(),
            'activity' => 'Mengakses form tambah tugas',
        ]);

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

        LogActivity::create([
            'user_id' => Auth::id(),
            'activity' => 'Menambahkan tugas baru: ' . $request->task,
        ]);

        return redirect()->route('dashboard')->with('success', 'Tugas berhasil ditambahkan!');
    }

    // Menampilkan detail tugas (readonly)
    public function show($id)
    {
        $task = TodolistModel::findOrFail($id);

        LogActivity::create([
            'user_id' => Auth::id(),
            'activity' => 'Melihat detail tugas: ' . $task->task,
        ]);

        return view('todolist_form', ['task' => $task, 'readonly' => true]);
    }

    // Menampilkan form edit tugas
    public function edit($id)
    {
        $task = TodolistModel::findOrFail($id);

        LogActivity::create([
            'user_id' => Auth::id(),
            'activity' => 'Mengakses form edit tugas: ' . $task->task,
        ]);

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

        LogActivity::create([
            'user_id' => Auth::id(),
            'activity' => 'Memperbarui tugas: ' . $task->task,
        ]);

        return redirect()->route('dashboard')->with('success', 'Tugas berhasil diperbarui!');
    }

    // Menghapus tugas
    public function destroy($id)
    {
        $task = TodolistModel::findOrFail($id);
        $taskTitle = $task->task;
        $task->delete();

        LogActivity::create([
            'user_id' => Auth::id(),
            'activity' => 'Menghapus tugas: ' . $taskTitle,
        ]);

        return redirect()->route('dashboard')->with('success', 'Tugas berhasil dihapus!');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Not Done,Done,Late'
        ]);

        $task = TodolistModel::findOrFail($id);
        $oldStatus = $task->status;
        $task->status = $request->status;
        $task->save();

        LogActivity::create([
            'user_id' => Auth::id(),
            'activity' => 'Mengubah status tugas "' . $task->task . '" dari ' . $oldStatus . ' menjadi ' . $request->status,
        ]);

        return redirect()->back()->with('success', 'Status tugas berhasil diperbarui!');
    }
}
