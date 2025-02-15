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
<<<<<<< HEAD
=======
    }
    public function showListPost()
    {
        return view('admin.articles.index');
    }
    public function showCreatePost()
    {
        return view('admin.articles.create');
    }
    public function showEditPost()
    {
        return view('admin.articles.edit');
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
>>>>>>> ab90c292c2e51dcf8c7cf171548ae4975f260007
    }
}
