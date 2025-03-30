<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    // Tên bảng
    protected $table = 'violations';

    // Khóa chính (nếu không phải 'id')
    protected $primaryKey = 'violation_id';

    // Nếu bảng không có cột created_at, updated_at thì đặt $timestamps = false
    public $timestamps = false;

    // Danh sách các cột có thể fill bằng Mass Assignment
    protected $fillable = [
        'type',
        'reference_id',
        'detected_word',
        'detected_at',
        'handled_by',
        'status',
        'warning_sent'
    ];
}
