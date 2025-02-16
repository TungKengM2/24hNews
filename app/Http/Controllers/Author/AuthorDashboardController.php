<?php

namespace App\Http\Controllers\author;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorDashboardController extends Controller
{
    public function index()
    {
        // Your code here
        return view('author.layouts.dashboard');
    }
}
