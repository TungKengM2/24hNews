<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Storage;


class SocialAuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Đăng nhập thất bại!');
        }

        // Tìm user theo email
        $user = User::where('email', $socialUser->getEmail())->first();

        if ($user) {
            // Nếu user đã tồn tại nhưng chưa liên kết với Google/Facebook, cập nhật
            if (empty($user->provider) || empty($user->provider_id)) {
                $user->update([
                    'provider'    => $provider,
                    'provider_id' => $socialUser->getId(),
                ]);
            }
        } else {
            // Tạo username không trùng lặp
            $username = $this->generateUniqueUsername($socialUser->getName());

            // Nếu muốn tải avatar về server
            $avatarPath = $this->downloadAvatar($socialUser->getAvatar());

            // Tạo user mới
            $user = User::create([
                'username'          => $username,
                'email'             => $socialUser->getEmail(),
                'image'             => $avatarPath, // Lưu avatar
                'email_verified_at' => now(),
                'password'          => null,
                'provider'          => $provider,
                'provider_id'       => $socialUser->getId(),
                'role_id'           => 4, // Mặc định role user
            ]);
        }

        Auth::login($user);

        return redirect('/');
    }

    /**
     * Tạo username không trùng lặp
     */
    private function generateUniqueUsername($baseUsername)
    {
        $username = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($baseUsername)); // Bỏ ký tự đặc biệt
        $username = substr($username, 0, 15); // Giới hạn 15 ký tự
        $originalUsername = $username;
        $count = 1;

        while (User::where('username', $username)->exists()) {
            $username = $originalUsername . $count;
            $count++;
        }

        return $username;
    }

    /**
     * Tải avatar về server
     */
    private function downloadAvatar($avatarUrl)
    {
        if (!$avatarUrl) return null;
    
        try {
            $contents = file_get_contents($avatarUrl);
            if (!$contents) {
                throw new \Exception("Không thể tải nội dung ảnh.");
            }
    
            $fileName = 'avatars/' . uniqid() . '.jpg';
            Storage::disk('public')->put($fileName, $contents);
    
            // Debug xem ảnh có được lưu không
            if (!Storage::disk('public')->exists($fileName)) {
                throw new \Exception("Lưu ảnh thất bại.");
            }
    
            return $fileName;
        } catch (\Exception $e) {
            \Log::error("Lỗi tải avatar: " . $e->getMessage());
            return null;
        }
    }
    
}
