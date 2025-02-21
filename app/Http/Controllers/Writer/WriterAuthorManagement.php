<?php

namespace App\Http\Controllers\Writer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class WriterAuthorManagement extends Controller
{
    public function index()
    {
        return view('writer.pages.author.index');
    }
}