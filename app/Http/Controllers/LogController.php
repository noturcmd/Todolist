<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LogActivity;


class LogController extends Controller
{
    public function index(Request $request)
    {
        $query = LogActivity::with('user');

        if ($request->has('search')) {
            $query->where('activity', 'like', '%' . $request->search . '%');
        }

        $logs = $query->latest()->paginate(15);

        return view('admin.logs.index', compact('logs'));
    }
}
