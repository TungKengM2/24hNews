<?php

    namespace App\Http\Controllers\Author;

    use App\Http\Controllers\Controller;
    use App\Models\Article;
    use App\Models\ArticleView;
    use Illuminate\Support\Facades\Auth;

    class AuthorDashboard extends Controller
    {

<<<<<<< HEAD
<<<<<<< HEAD
        // public function __construct()
        // {
        //     $this->middleware('auth');
        //     $this->middleware('role:author');
        // }
=======
        public function __construct()
        {
            $this->middleware('auth');
            $this->middleware('role:author');
        }
>>>>>>> 4f4bd7cc0ce4f018506921aec4238874f7978459

        public function index()
        {
            $user = Auth::user();
            $articleStats = [
                'total' => Article::where('author_id', $user->user_id)->count(),
                'published' => Article::where('author_id', $user->user_id)
                    ->where('status', 'published')
                    ->count(),
                'pending' => Article::where('author_id', $user->user_id)
                    ->where('status', 'pending')
                    ->count(),
                'draft' => Article::where('author_id', $user->user_id)
                    ->where('status', 'draft')
                    ->count(),
            ];

<<<<<<< HEAD
            // $viewsData = ArticleView::where('user_id', $user->user_id)
            //     ->selectRaw('DATE(viewed_at) as date, COUNT(*) as views')
            //     ->groupBy('date')
            //     ->orderBy('date')
            //     ->get()
            //     ->mapWithKeys(function ($item) {
            //         return [$item->date => $item->views];
            //     });
            // //            dd($viewsData);
            // //            dd($articleStats);
            // return view('author.dashboard',
            //     compact('articleStats', 'viewsData'));
        }

    }
=======
        public function __construct()
        {
            $this->middleware('auth');
            $this->middleware('role:author');
        }

        public function index()
        {
            $user = Auth::user();
            $articleStats = [
                'total' => Article::where('author_id', $user->user_id)->count(),
                'published' => Article::where('author_id', $user->user_id)
                    ->where('status', 'published')
                    ->count(),
                'pending' => Article::where('author_id', $user->user_id)
                    ->where('status', 'pending')
                    ->count(),
                'draft' => Article::where('author_id', $user->user_id)
                    ->where('status', 'draft')
                    ->count(),
            ];

            $viewsData = ArticleView::where('user_id', $user->user_id)
                ->selectRaw('DATE(viewed_at) as date, COUNT(*) as views')
                ->groupBy('date')
                ->orderBy('date')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->date => $item->views];
                });
            //            dd($viewsData);
            //            dd($articleStats);
            return view('author.dashboard',
                compact('articleStats', 'viewsData'));
        }

    }
>>>>>>> tungkeng
=======
            $viewsData = ArticleView::where('user_id', $user->user_id)
                ->selectRaw('DATE(viewed_at) as date, COUNT(*) as views')
                ->groupBy('date')
                ->orderBy('date')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->date => $item->views];
                });
            //            dd($viewsData);
            //            dd($articleStats);
            return view('author.dashboard',
                compact('articleStats', 'viewsData'));
        }

    }
>>>>>>> 4f4bd7cc0ce4f018506921aec4238874f7978459
