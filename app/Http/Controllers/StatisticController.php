<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TodolistModel;

class StatisticController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $date   = $request->query('date');

        $query = TodolistModel::query();

        if ($status && $status != 'all') {
            $query->where('status', $status);
        }

        if ($date) {
            $query->whereDate('deadline', $date);
        }

        $tasks = $query->orderBy('created_at', 'desc')->paginate(10);

        // data chart
        $countDone    = TodolistModel::where('status', 'Done')->count();
        $countNotDone = TodolistModel::where('status', 'Not Done')->count();
        $countLate    = TodolistModel::where('status', 'Late')->count();

        return view('statistics_page', compact('tasks', 'countDone', 'countNotDone', 'countLate'));
    }
}

