<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ModeratorArticleController extends Controller
{
    public function index()
    {
        // $articles = Article::where('author_id', auth()->user()->user_id)->get();
        return view('moderator.pages.articles.index');
    }
}
