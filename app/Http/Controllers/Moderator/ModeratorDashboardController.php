<?php

namespace App\Http\Controllers\Moderator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ModeratorDashboardController extends Controller
{
    public function index()
    {
        // Your code here
        return view('moderator.layouts.dashboard');
    }
}
