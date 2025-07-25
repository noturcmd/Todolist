<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TodolistModel;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function statistics(Request $request)
    {
        $status = $request->input('status', 'all');
        $dateFilter = $request->input('date', '');

        $query = TodolistModel::query();

        // filter status
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // filter tanggal (misal hanya berdasarkan tanggal deadline)
        if ($dateFilter) {
            $query->whereDate('deadline', $dateFilter);
        }

        $tasks = $query->orderBy('created_at', 'desc')->paginate(10);

        // summary data for chart
        $countDone = TodolistModel::where('status', 'Done')->count();
        $countNotDone = TodolistModel::where('status', 'Not Done')->count();
        $countLate = TodolistModel::where('status', 'Late')->count();

        if (Auth::check()) {
            LogActivity::create([
                'user_id' => Auth::id(),
                'activity' => 'Mengakses statistik semua tugas',
            ]);
        }

        return view('statistics_page', compact('tasks', 'countDone', 'countNotDone', 'countLate'));
    }

}
