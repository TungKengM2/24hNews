<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;
    protected $table = 'approvals';

    protected $primaryKey = 'approval_id';

    protected $fillable = [
        'type',
        'article_id',
        'user_id',
        'approved_by',
        'requested_role',
        'status',
        'auto_reviewed',
        'remarks',
        'violation_level',
        'violations',
        'violation_details',
        'cccd_front',
        'cccd_back',
        'cccd_number',
        'certificates'
    ];

    protected $casts = [
        'violations' => 'array',
        'violation_details' => 'array',
        'cccd_front',
        'cccd_back',
        'cccd_number',
        'certificates'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
