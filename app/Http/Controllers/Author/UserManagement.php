<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserManagement extends Controller
{
    public function index()
    {
        return view('author.pages.users.index');
    }
}
