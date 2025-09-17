<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Dashboard statistics
        $stats = [
            'total_users' => User::where('u_type', 'USR')->count(),
            'total_admins' => User::whereIn('u_type', ['ADM', 'MGR'])->count(),
            'total_all_users' => User::count(),
            // Add more stats as needed
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
