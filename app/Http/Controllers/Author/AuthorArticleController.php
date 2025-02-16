<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class AuthorArticleController extends Controller
{
    public function index()
    {
        // $articles = Article::where('author_id', auth()->user()->user_id)->get();
        return view('author.pages.articles.index');
    }
}
