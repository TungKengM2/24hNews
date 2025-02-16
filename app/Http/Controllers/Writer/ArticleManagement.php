<?php

namespace App\Http\Controllers\Writer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleManagement extends Controller
{
    public function index()
    {
        return view('writer.pages.articles.index');
    }
}