<?php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ArticleHistory;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {

        // $articles = Article::latest()->get();


        // return view('welcome', compact('articles'));
        return view('welcome');
    }



}
