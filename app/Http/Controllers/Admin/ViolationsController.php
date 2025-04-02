<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use App\Models\Violation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Notifications\NewArticleSubmitted;
use App\Notifications\ArticleStatusUpdated;
use Illuminate\Support\Facades\Notification;

class ViolationsController extends Controller
{
    /**
     *
     */
    public function approves(Request $request)
{
    // Lấy các vi phạm có trạng thái 'pending' (chờ duyệt)
    $violations = Violation::where('status', 'pending')->paginate(10);

    // Xử lý nếu cần, ví dụ như duyệt vi phạm

    // Trả về view với dữ liệu vi phạm đã được duyệt
    return view('admin.violations.approves', compact('violations'));
}
}