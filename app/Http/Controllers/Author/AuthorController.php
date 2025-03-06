<?php

    namespace App\Http\Controllers\Author;

    use App\Http\Controllers\Controller;
    use App\Models\Article;
    use App\Models\Category;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Storage;

    class AuthorController extends Controller
    {

        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            return view('author.articles.index');
        }

        public function create()
        {
            return view('author.articles.create');
        }

    }
