<?php

namespace App\Helpers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class NotificationHelper
{
    /**
     * Gửi thông báo tùy chỉnh cho người dùng
     *
     * @param User $user Người dùng nhận thông báo
     * @param string $title Tiêu đề thông báo
     * @param string $message Nội dung thông báo
     * @param string $type Loại thông báo
     * @param array $data Dữ liệu bổ sung
     * @return Notification|null
     */
    public static function sendCustomNotification(User $user, string $title, string $message, string $type, array $data = [])
    {
        try {
            return Notification::create([
                'user_id' => $user->user_id,
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'data' => json_encode($data),
                'read_at' => null
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi gửi thông báo: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Gửi thông báo tùy chỉnh cho nhiều người dùng
     *
     * @param array|Collection $users Danh sách người dùng nhận thông báo
     * @param string $title Tiêu đề thông báo
     * @param string $message Nội dung thông báo
     * @param string $type Loại thông báo
     * @param array $data Dữ liệu bổ sung
     * @return int Số lượng thông báo đã gửi thành công
     */
    public static function sendCustomNotificationToMany($users, string $title, string $message, string $type, array $data = [])
    {
        $count = 0;
        foreach ($users as $user) {
            if (self::sendCustomNotification($user, $title, $message, $type, $data)) {
                $count++;
            }
        }
        return $count;
    }

    /**
     * Chuyển đổi thông báo Laravel thành thông báo tùy chỉnh
     *
     * @param User $user Người dùng nhận thông báo
     * @param object $notification Đối tượng thông báo Laravel
     * @return Notification|null
     */
    public static function convertLaravelNotification(User $user, $notification)
    {
        try {
            // Lấy dữ liệu từ phương thức toArray hoặc toDatabase
            $data = method_exists($notification, 'toArray') 
                ? $notification->toArray($user) 
                : (method_exists($notification, 'toDatabase') 
                    ? $notification->toDatabase($user) 
                    : []);
            
            // Đảm bảo có title và message
            if (!isset($data['title']) || !isset($data['message'])) {
                throw new \Exception('Thông báo phải có cả title và message');
            }
            
            // Lấy type từ tên class
            $type = get_class($notification);
            
            // Tạo thông báo tùy chỉnh
            return self::sendCustomNotification(
                $user,
                $data['title'],
                $data['message'],
                $type,
                $data
            );
        } catch (\Exception $e) {
            Log::error('Lỗi chuyển đổi thông báo: ' . $e->getMessage());
            return null;
        }
    }
}
