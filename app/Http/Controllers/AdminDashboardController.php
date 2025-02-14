<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    // POST
    {
        return view('admin.layouts.dashboard');
    }
    public function showListPost()
    {
        return view('admin.post.listpost');
    }
    public function showCreatePost()
    {
        return view('admin.post.createpost');
    }
    public function showEditPost()
    {
        return view('admin.post.editpost');
    }
    // CATEGORY
    public function showListCategory()
    {
        return view('admin.categories.listcategories');
    }
    public function showCreateCategory()
    {
        return view('admin.categories.createcategories');
    }
    public function showEditCategory()
    {
        return view('admin.categories.editcategories');
    }
}
