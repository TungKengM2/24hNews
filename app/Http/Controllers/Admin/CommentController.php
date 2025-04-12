<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\ModerationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the comments.
     */
    public function index()
    {
        $comments = Comment::with(['user', 'article'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Show the specified comment.
     */
    public function show(Comment $comment)
    {
        return view('admin.comments.show', compact('comment'));
    }

    /**
     * Approve a comment.
     */
    public function approve(Comment $comment)
    {
        if ($comment->status === 'approved') {
            return redirect()->back()->with('error', 'Bình luận đã được duyệt trước đó.');
        }

        $beforeState = [
            'status' => $comment->status,
        ];

        $comment->status = 'approved';
        $comment->save();

        $afterState = [
            'status' => $comment->status,
        ];

        // Comment moderation history has been removed

        return redirect()->back()->with('success', 'Bình luận đã được duyệt thành công.');
    }

    /**
     * Reject a comment.
     */
    public function reject(Comment $comment)
    {
        if ($comment->status === 'rejected') {
            return redirect()->back()->with('error', 'Bình luận đã bị từ chối trước đó.');
        }

        $beforeState = [
            'status' => $comment->status,
        ];

        $comment->status = 'rejected';
        $comment->save();

        $afterState = [
            'status' => $comment->status,
        ];

        // Comment moderation history has been removed

        return redirect()->back()->with('success', 'Bình luận đã bị từ chối thành công.');
    }

    /**
     * Delete a comment.
     */
    public function destroy(Comment $comment)
    {
        $beforeState = [
            'status' => $comment->status,
            'content' => strip_tags($comment->content),
        ];

        // Comment moderation history has been removed

        $comment->delete();

        return redirect()->route('admin.comments.index')->with('success', 'Bình luận đã được xóa thành công.');
    }
}
