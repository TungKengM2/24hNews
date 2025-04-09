<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';      // Tên bảng
    protected $primaryKey = 'comment_id'; // Khóa chính
        // Nếu không có cột created_at, updated_at

    protected $fillable = [
        'article_id',
        'user_id',
        'content',
        'parent_id',
        'depth',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id')
            ->select([
                'user_id', // Dùng 'user_id' thay vì 'id'
                'username',
                'phone',
                'image',
                'email',
                'email_verified_at',
                'role_id',
                'is_promoted',
                'violation_count',
                'banned_until',
                'created_at',
                'updated_at',
            ]);
    }


    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('replies');
    }

    // Thêm quan hệ với reactions
    public function reactions()
    {
        return $this->hasMany(
            CommentReaction::class,
            'comment_id',
            'comment_id'
        );
    }



    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}
