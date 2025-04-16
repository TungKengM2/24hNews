<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Notifications\AuthorUpgradeRequest;

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

    public function profileModerator()
    {
        $user = auth()->user();
        //            dd($user);
        return view('moderator.profile', compact('user'));
    }

    public function profileAuthor()
    {
        $user = auth()->user();
        //            dd($user);
        return view('author.profile', compact('user'));
    }

    public function index()
    {
        $user = Auth::user();

        return view('profile.index', compact('user'));
    }
    //fl user
    public function followingList()
    {
        $user = auth()->user();
        $followingUsers = $user->following()->paginate(10);
        // dat them
        return view('website.profiles.users.following', compact('followingUsers', 'user'));
    }
    //fl author
    public function followingOfAuthorList()
    {
        $user = auth()->user();
        $followingUsers = $user->following()->paginate(10);

        return view('author.following', compact('followingUsers'));
    }
    //fl moderator
    public function followingOfModeratorList()
    {
        $user = auth()->user();
        $followingUsers = $user->following()->paginate(10);

        return view('moderator.following', compact('followingUsers'));
    }
    //fl admin
    public function followingOfAdminList()
    {
        $user = auth()->user();
        $followingUsers = $user->following()->paginate(10);

        return view('admin.following', compact('followingUsers'));
    }

    public function upgradeToAuthor()
    {
        $user = auth()->user();

        // Ghi log để gỡ lỗi
        Log::info('Bắt đầu kiểm tra yêu cầu nâng cấp', [
            'user_id' => $user->user_id,
            'user_name' => $user->name
        ]);

        // Kiểm tra xem user đã gửi yêu cầu chưa
        $existingRequest = Approval::where('user_id', $user->user_id)
            ->where('type', 'role_upgrade')
            ->where('requested_role', 'author')
            ->latest()
            ->first();

        // Ghi log để gỡ lỗi
        Log::info('Kết quả kiểm tra yêu cầu nâng cấp', [
            'user_id' => $user->user_id,
            'request' => $existingRequest
        ]);

        if ($existingRequest) {
            if ($existingRequest->status === 'pending') {
                Log::info('Người dùng đã có yêu cầu nâng cấp đang chờ duyệt', [
                    'user_id' => $user->user_id
                ]);

                return redirect()->to('/user/upgrade-result')
                    ->with('error', 'Bạn đã gửi yêu cầu trước đó và đang chờ duyệt.');
            } elseif ($existingRequest->status === 'approved') {
                Log::info('Người dùng đã được nâng cấp thành tác giả', [
                    'user_id' => $user->user_id
                ]);

                return redirect()->to('/user/upgrade-result')
                    ->with('error', 'Bạn đã là tác giả của hệ thống.');
            }
            // Nếu yêu cầu bị từ chối, cho phép gửi yêu cầu mới
        }

        Log::info('Người dùng chưa có yêu cầu nâng cấp hoặc yêu cầu đã bị từ chối', [
            'user_id' => $user->user_id
        ]);

        return view('website.profiles.users.upgrade', compact('user'));
    }

    public function requestAuthorRole(Request $request)
    {
        $user = auth()->user();

        // Kiểm tra xem user đã có yêu cầu đang chờ duyệt chưa
        $existingRequest = Approval::where([
            'user_id' => $user->user_id,
            'type' => 'role_upgrade',
            'status' => 'pending',
            'requested_role' => 'author'
        ])->first();

        if ($existingRequest) {
            return redirect()->route('user.upgrade.result')
                ->with('error', 'Bạn đã gửi yêu cầu trước đó và đang chờ duyệt.');
        }

        try {
            // Validate dữ liệu
            $request->validate([
                'fullname' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'address' => 'required|string|max:255',
                'dob' => 'required|date',
                'cccd_number' => 'required|string|size:12',
                'cccd_front' => 'required|image|mimes:jpeg,png,jpg|max:4048',
                'cccd_back' => 'required|image|mimes:jpeg,png,jpg|max:4048',
                'certificates' => 'required|array',
                'certificates.*' => 'required|file|mimes:pdf|max:10240',
            ]);

            // Kiểm tra xem số CCCD đã được sử dụng chưa
            $cccdUsed = Approval::where('cccd_number', $request->cccd_number)
                ->where(function($query) {
                    $query->where('status', 'pending')
                        ->orWhere('status', 'approved');
                })
                ->first();

            if ($cccdUsed) {
                return redirect()->back()
                    ->with('error', 'Số CCCD này đã được sử dụng cho một yêu cầu khác.');
            }

            // Quét số CCCD từ ảnh mặt trước
            $cccdFrontPath = $request->file('cccd_front')->store('cccd_images', 'public');
            $cccdBackPath = $request->file('cccd_back')->store('cccd_images', 'public');

            try {
                // OCR trích xuất số CCCD từ ảnh
                Log::info("Ảnh CCCD Front: " . $cccdFrontPath);

                // Kiểm tra xem file ảnh có tồn tại không
                if (!file_exists(storage_path("app/public/" . $cccdFrontPath))) {
                    throw new \Exception("Ảnh CCCD không tồn tại");
                }

                // Sử dụng OCR để trích xuất số CCCD từ ảnh mặt trước
                $ocr = new TesseractOCR(storage_path("app/public/" . $cccdFrontPath));
                $ocr->psm(3)
                    ->oem(1)
                    ->lang('eng')
                    ->tempDir(storage_path('app/temp'));

                try {
                    $extractedText = $ocr->run();
                } catch (\Exception $e) {
                    throw new \Exception("Ảnh CCCD bị mờ");
                }

                // Kiểm tra xem có kết quả quét không
                if (empty($extractedText)) {
                    throw new \Exception("Ảnh CCCD bị mờ");
                }

                // Trích xuất số CCCD từ chuỗi text bằng regex
                preg_match('/\d{12}/', str_replace(' ', '', $extractedText), $matches);
                $extractedCCCD = $matches[0] ?? null;

                if (!$extractedCCCD) {
                    // Xóa ảnh đã tải lên
                    Storage::delete([
                        'public/' . $cccdFrontPath,
                        'public/' . $cccdBackPath
                    ]);

                    return redirect()->back()->with('error', 'Ảnh CCCD bị mờ');
                }

                if ($extractedCCCD !== $request->cccd_number) {
                    // Xóa ảnh đã tải lên
                    Storage::delete([
                        'public/' . $cccdFrontPath,
                        'public/' . $cccdBackPath
                    ]);

                    return redirect()->back()->with('error', 'Số CCCD không khớp');
                }
            } catch (\Exception $e) {
                // Xóa ảnh đã tải lên nếu có lỗi trong quá trình quét
                Storage::delete([
                    'public/' . $cccdFrontPath,
                    'public/' . $cccdBackPath
                ]);

                Log::error('Lỗi khi quét CCCD', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                return redirect()->back()->with('error', 'Ảnh CCCD bị mờ');
            }

            // Lưu chứng chỉ
            $certificatePaths = [];
            if ($request->hasFile('certificates')) {
                foreach ($request->file('certificates') as $certificate) {
                    $path = $certificate->store('certificates', 'public');
                    $certificatePaths[] = str_replace('public/', '', $path);
                }
            }

            // Cập nhật thông tin user
            $user->update([
                'fullname' => $request->fullname,
                'phone' => $request->phone,
                'address' => $request->address,
                'dob' => $request->dob,
            ]);

            // Tạo yêu cầu nâng cấp
            $approval = new Approval();
            $approval->type = 'role_upgrade';
            $approval->user_id = $user->user_id;
            $approval->requested_role = 'author';
            $approval->status = 'pending';
            $approval->cccd_number = $request->cccd_number;
            $approval->cccd_front = str_replace('public/', '', $cccdFrontPath);
            $approval->cccd_back = str_replace('public/', '', $cccdBackPath);
            $approval->certificates = json_encode($certificatePaths);
            $approval->save();

            // Gửi thông báo cho tất cả admin
            $admins = User::where('role_id', 1)->get();
            foreach ($admins as $admin) {
                $admin->notify(new AuthorUpgradeRequest($user));
            }

            return redirect()->route('user.upgrade.result')
                ->with('status', 'Yêu cầu nâng cấp tài khoản đã được gửi thành công.');

        } catch (\Exception $e) {
            \Log::error('Error in requestAuthorRole', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $user->user_id
            ]);

            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi gửi yêu cầu: ' . $e->getMessage());
        }
    }

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
            'description' => ['nullable', 'string', 'max:150'],
            'phone' => ['nullable', 'regex:/^0[0-9]{9}$/'],
        ]);

        // Kiểm tra nếu dữ liệu không thay đổi
        if ($request->username == $user->username && $request->description == $user->description && $request->phone == $user->phone) {
            return back()->with(
                'error',
                'Không có thay đổi nào được thực hiện.'
            );
        }

        // Cập nhật dữ liệu
        $user->update([
            'username' => $request->username,
            'description' => $request->description ?? '',
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
            'description' => 'required|string|max:150',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
        ]);

        // Retrieve the authenticated user
        $user = auth()->user();
        $user->name = $request->name;
        $user->description = $request->description;
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
            $imagePath = $image->store(
                'avatars',
                'public'
            ); // Store the image in the 'avatars' folder in the 'public' disk

            // Update the user's image path in the database
            $user = auth()->user();
            $user->image = $imagePath; // Save the image path to the 'image' column
            $user->save();

            // Return the updated image URL
            return response()->json([
                'success' => true,
                'image_url' => asset('storage/' . $imagePath),
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
                ->with(
                    'error',
                    'Tài khoản của bạn đăng nhập bằng Google/Facebook, không thể đổi mật khẩu.'
                );
        }
        // dat them
        return view('website.profiles.users.change-password', compact('user'));
    }

    public function showChangePasswordFormModerator()
    {
        $user = Auth::user();

        // Nếu user đăng nhập bằng Google/Facebook, chuyển hướng về profile với thông báo
        if (! $user->password) {
            return redirect()
                ->route('profile')
                ->with(
                    'error',
                    'Tài khoản của bạn đăng nhập bằng Google/Facebook, không thể đổi mật khẩu.'
                );
        }

        return view('moderator.profile-setting');
    }

    public function showChangePasswordFormAuthor()
    {
        $user = Auth::user();

        // Nếu user đăng nhập bằng Google/Facebook, chuyển hướng về profile với thông báo
        if (! $user->password) {
            return redirect()
                ->route('profile')
                ->with(
                    'error',
                    'Tài khoản của bạn đăng nhập bằng Google/Facebook, không thể đổi mật khẩu.'
                );
        }

        return view('author.profile-setting');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // Nếu user đăng nhập bằng Google/Facebook thì không cho đổi mật khẩu
        if (! $user->password) {
            return redirect()
                ->route('profile')
                ->with(
                    'error',
                    'Tài khoản của bạn đăng nhập bằng Google/Facebook, không thể đổi mật khẩu.'
                );
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
