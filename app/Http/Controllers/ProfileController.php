<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $user = auth()->user();

        //            dd($user);
        return view('user.dashboard', compact('user'));
    }

    public function index()
    {
        $user = Auth::user();

        return view('profile.index', compact('user'));
    }

    public function edit()
    {
        return view('client.profile.layouts.home');
    }

    public function upgradeToAuthor()
    {
        $user = auth()->user();

        return view('user.upgrade', compact('user'));
    }

    public function requestAuthorRole(Request $request)
    {
        $existingRequest = Approval::where('type', 'role_upgrade')
            ->where('status', 'pending')
            ->where('requested_role', 'author')
            ->where('user_id', auth()->id())
            ->exists();

        if ($existingRequest) {
            return redirect()
                ->route('user.upgrade.result')
                ->with('error', 'You have already submitted a request.');
        }

        Approval::create([
            'type' => 'role_upgrade',
            'article_id' => null,
            'approved_by' => null,
            'status' => 'pending',
            'requested_role' => 'author',
            'remarks' => $request->input('reason', 'No reason provided'),
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('user.upgrade.result')
            ->with('status',
                'Your request has been submitted successfully.');
    }

    /**
     * Hiển thị trang profile
     */

    /**
     * Cập nhật thông tin cá nhân
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users')->ignore($user->user_id, 'user_id'),
            ],
            'phone' => ['nullable', 'regex:/^0[0-9]{9}$/'],
        ]);

        // Kiểm tra nếu dữ liệu không thay đổi
        if ($request->username == $user->username && $request->phone == $user->phone) {
            return back()->with('error',
                'Không có thay đổi nào được thực hiện.');
        }

        // Cập nhật dữ liệu
        $user->update([
            'username' => $request->username,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }

    /**
     * Update the profile.
     *
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.auth()->id(),
        ]);

        // Retrieve the authenticated user
        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;

        // Update the password if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);

            $user->password = bcrypt($request->password);
        }

        // Save the updated user data
        $user->save();

        // Redirect back to the profile edit page with a success message
        return redirect()
            ->route('profile.edit')
            ->with('status', 'Profile updated successfully.');
    }

    public function uploadAvatar(Request $request)
    {
        // Validate file input
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Check if the file exists
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('avatars',
                'public'); // Store the image in the 'avatars' folder in the 'public' disk

            // Update the user's image path in the database
            $user = auth()->user();
            $user->image = $imagePath; // Save the image path to the 'image' column
            $user->save();

            // Return the updated image URL
            return response()->json([
                'success' => true,
                'image_url' => asset('storage/'.$imagePath),
                // Return the new image URL
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No image file was uploaded.',
        ]);
    }

    /**
     * Đổi mật khẩu
     */
    public function showChangePasswordForm()
    {
        $user = Auth::user();

        // Nếu user đăng nhập bằng Google/Facebook, chuyển hướng về profile với thông báo
        if (! $user->password) {
            return redirect()
                ->route('profile')
                ->with('error',
                    'Tài khoản của bạn đăng nhập bằng Google/Facebook, không thể đổi mật khẩu.');
        }

        return view('profile.change-password');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // Nếu user đăng nhập bằng Google/Facebook thì không cho đổi mật khẩu
        if (! $user->password) {
            return redirect()
                ->route('profile')
                ->with('error',
                    'Tài khoản của bạn đăng nhập bằng Google/Facebook, không thể đổi mật khẩu.');
        }

        // Kiểm tra dữ liệu nhập vào
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        // Kiểm tra mật khẩu hiện tại
        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }

        // Cập nhật mật khẩu mới
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }
}
