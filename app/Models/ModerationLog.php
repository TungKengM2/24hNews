<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModerationLog extends Model
{
    use HasFactory;

    /**
     * Tên bảng liên kết với model.
     *
     * @var string
     */
    protected $table = 'moderation_logs';

    /**
     * Khóa chính của bảng.
     *
     * @var string
     */
    protected $primaryKey = 'log_id';

    /**
     * Các thuộc tính có thể gán giá trị.
     *
     * @var array
     */
    protected $fillable = [
        'action_type',
        'content_type',
        'content_id',
        'moderator_id',
        'details',
        'before_state',
        'after_state',
        'severity',
    ];

    /**
     * Các thuộc tính nên được ép kiểu.
     *
     * @var array
     */
    protected $casts = [
        'details' => 'array',
        'before_state' => 'array',
        'after_state' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Lấy người kiểm duyệt liên quan đến log này.
     */
    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderator_id', 'user_id');
    }

    /**
     * Tạo một log kiểm duyệt mới.
     *
     * @param string $actionType Loại hành động (approve, reject, flag, edit, delete, restore, auto_moderate)
     * @param string $contentType Loại nội dung (article, comment, user, category, role_upgrade)
     * @param int $contentId ID của nội dung
     * @param array $details Chi tiết về hành động
     * @param array|null $beforeState Trạng thái trước khi thực hiện hành động
     * @param array|null $afterState Trạng thái sau khi thực hiện hành động
     * @param string $severity Mức độ nghiêm trọng (none, low, medium, high)
     * @return ModerationLog
     */
    public static function createLog(
        string $actionType,
        string $contentType,
        int $contentId,
        array $details,
        ?array $beforeState = null,
        ?array $afterState = null,
        string $severity = 'none'
    ): self {
        return self::create([
            'action_type' => $actionType,
            'content_type' => $contentType,
            'content_id' => $contentId,
            'moderator_id' => auth()->id(),
            'details' => $details,
            'before_state' => $beforeState,
            'after_state' => $afterState,
            'severity' => $severity,
        ]);
    }
}
