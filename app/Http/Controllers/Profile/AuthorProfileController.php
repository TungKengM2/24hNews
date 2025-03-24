<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorProfileController extends Controller
{
    public function show($user_id)
    {
        $user = auth()->user();
        $author = User::withCount('articles')->with('articles')->findOrFail($user_id);

        if ($user->role === 'admin' || $user->id == $author->id) {
            return view('website.profiles.author', compact('author'));
        } else {
            abort(403, 'Bạn không có quyền truy cập trang này!');
        }
    }
}
