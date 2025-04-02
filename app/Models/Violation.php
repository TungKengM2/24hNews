<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Violation extends Model
{
    // Tên bảng
    protected $table = 'violations';

    // Khóa chính
    protected $primaryKey = 'violation_id';

    // Nếu bảng không có cột created_at, updated_at thì đặt $timestamps = false
    public $timestamps = false;

    // Các cột có thể fill bằng Mass Assignment
    protected $fillable = [
        'type',
        'reference_id',
        'detected_word',
        'detected_at',
        'handled_by',
        'status',
        'warning_sent'
    ];

    // Quan hệ với bảng users (người xử lý)
    // Violation.php
    public function handledByUser()
    {
        return $this->belongsTo(User::class, 'handled_by', 'user_id');
    }
    // Violation.php
    public function article()
    {
        return $this->belongsTo(Article::class, 'reference_id', 'article_id');
    }
    public function comments()
{
    return $this->hasMany(Comment::class, 'article_id', 'reference_id');
}


    



}
