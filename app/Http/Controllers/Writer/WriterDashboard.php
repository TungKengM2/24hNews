<?php

namespace App\Http\Controllers\Writer;

use App\Http\Controllers\Controller;

class WriterDashboard extends Controller
{
    public function index()
    {
        return view('writer.layouts.dashboard');

    }
}
