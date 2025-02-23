<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use App\Models\Approval;

class ModeratorDashboardController extends Controller
{
    public function index()
    {
        // Your code here
        return view('moderator.layouts.dashboard');
    }

    public function dashboard()
    {
        $pendingRequests = Approval::where('type', 'role_upgrade')
            ->where('status', 'pending')
            ->with('user')
            ->get();

        return view('moderator.dashboard', compact('pendingRequests'));
    }
}
