<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ModeratorProfileController extends Controller
{
    public function index()
    {
        // Your code here
        return view('client.profile.layouts.home');
    }
}
