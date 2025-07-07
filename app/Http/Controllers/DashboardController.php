<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
{
    LogActivity::create([
        'user_id' => Auth::id(),
        'activity' => 'Mengakses halaman dashboard',
    ]);

    return view('dashboard');
}


}
