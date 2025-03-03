<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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

        // Kiểm tra xem user đã tồn tại hay chưa (dựa trên email)
        $user = User::where('email', $socialUser->getEmail())->first();

        if ($user) {
            // Nếu user đã tồn tại nhưng chưa liên kết với Google/Facebook thì cập nhật
            if (!$user->provider || !$user->provider_id) {
                $user->update([
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                ]);
            }
        } else {
            // Nếu chưa có user, tạo mới
            $username = $this->generateUniqueUsername($socialUser->getName());

            $user = User::create([
                'username' => $username,
                'email' => $socialUser->getEmail(),
                'image' => $socialUser->getAvatar(),
                'email_verified_at' => now(),
                'password' => null,
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'role_id' => 4, // Role mặc định cho user
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
        $username = str_replace(' ', '', strtolower($baseUsername)); // Bỏ khoảng trắng
        $originalUsername = $username;
        $count = 1;

        while (User::where('username', $username)->exists()) {
            $username = $originalUsername . $count;
            $count++;
        }

        return $username;
    }
}
