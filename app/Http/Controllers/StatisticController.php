<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TodolistModel;
use Illuminate\Support\Facades\Auth;
use App\Models\LogActivity;

class StatisticController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userId = auth()->id(); // ← ambil ID user yang sedang login

        LogActivity::create([
            'user_id' => $userId,
            'activity' => 'Melihat halaman statistik to-do list',
        ]);

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

