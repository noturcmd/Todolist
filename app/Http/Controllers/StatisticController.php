<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TodolistModel;

class StatisticController extends Controller
{
    public function index(Request $request)
    {
        if (!request()->cookie('user_email')) {
            return redirect('/login')->with('error', 'Sesi tidak ditemukan. Silakan login kembali.');
        }

        $userId = auth()->id(); // ← ambil ID user yang sedang login

        $status = $request->query('status');
        $date   = $request->query('date');

        $query = TodolistModel::where('user_id', $userId); // ← filter berdasarkan user_id

        if ($status && $status != 'all') {
            $query->where('status', $status);
        }

        if ($date) {
            $query->whereDate('deadline', $date);
        }

        $tasks = $query->orderBy('created_at', 'desc')->paginate(10);

        // data chart hanya untuk user ini juga
        $countDone    = TodolistModel::where('user_id', $userId)->where('status', 'Done')->count();
        $countNotDone = TodolistModel::where('user_id', $userId)->where('status', 'Not Done')->count();
        $countLate    = TodolistModel::where('user_id', $userId)->where('status', 'Late')->count();

        return view('statistics_page', compact('tasks', 'countDone', 'countNotDone', 'countLate'));
    }

}

