<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommentReaction extends Model
{
    use HasFactory;

    protected $table = 'comment_reactions'; // Tên bảng trong database
    protected $primaryKey = 'reaction_id'; // Khóa chính
    public $timestamps = false; // Vì bảng không có cột `created_at` và `updated_at`

    protected $fillable = [
        'comment_id',
        'user_id',
        'is_like',
        'reacted_at'
    ];

    protected $casts = [
        'is_like' => 'boolean',
        'reacted_at' => 'datetime',
    ];

    // Quan hệ với bảng `comments`
    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id', 'comment_id');
    }

    // Quan hệ với bảng `users`
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    private function handleCommentReaction($commentId, $isLike)
{
    $userId = auth()->id();
    if (!$userId) {
        return response()->json(['success' => false, 'message' => 'Bạn cần đăng nhập để thực hiện thao tác!']);
    }

    // Kiểm tra xem phản ứng đã tồn tại chưa
    $reaction = CommentReaction::where('comment_id', $commentId)
        ->where('user_id', $userId)
        ->first();

    if ($reaction) {
        if ($reaction->is_like === $isLike) {
            $reaction->delete(); // Hủy like/dislike
            $changed = false;
        } else {
            $reaction->update([
                'is_like' => $isLike,
                'reacted_at' => now(), // Cập nhật thời gian phản ứng
            ]);
            $changed = true;
        }
    } else {
        CommentReaction::create([
            'comment_id' => $commentId,
            'user_id' => $userId,
            'is_like' => $isLike,
            'reacted_at' => now(), // Thêm thời gian khi tạo mới
        ]);
        $changed = true;
    }

    // Lấy lại số lượt like/dislike sau khi cập nhật
    $likeCount = CommentReaction::where('comment_id', $commentId)->where('is_like', true)->count();
    $dislikeCount = CommentReaction::where('comment_id', $commentId)->where('is_like', false)->count();

    return response()->json([
        'success' => true,
        'changed' => $changed,
        'likeCount' => $likeCount,
        'dislikeCount' => $dislikeCount
    ]);
}

}
