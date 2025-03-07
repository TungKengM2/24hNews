<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Approval extends Model
    {

        protected $table = 'approvals';

        protected $fillable = [
            'type',
            'article_id',
            'user_id',
            'approved_by',
            'requested_role',
            'status',
            'auto_reviewed',
            'remarks',
        ];

        public function user()
        {
            return $this->belongsTo(User::class, 'user_id');
        }

    }
