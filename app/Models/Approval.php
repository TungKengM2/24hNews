<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    public $timestamps = false;

    protected $table = 'approvals';

    protected $primaryKey = 'approval_id';

    protected $fillable = [
        'article_id',
        'user_id',
        'approved_by',
        'type',
        'requested_role',
        'status',
        'auto_reviewed',
        'remarks',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id', 'article_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
