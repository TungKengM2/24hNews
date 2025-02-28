<?php

    namespace App\Http\Controllers\Author;

    use App\Http\Controllers\Controller;
    use App\Models\Article;
    use App\Models\ArticleView;
    use Illuminate\Support\Facades\Auth;

    class AuthorDashboard extends Controller
    {

        // public function __construct()
        // {
        //     $this->middleware('auth');
        //     $this->middleware('role:author');
        // }

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