<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:author');
    }

    public function edit()
    {
        $user = Auth::user();

        return view('author.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'username' => 'sometimes|string|max:50|unique:users,username,'.$user->user_id.',user_id',
            'phone' => 'sometimes|string|max:15',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('profile_images', 'public');
            $data['image'] = $imagePath;
        }

        $user->update($data);

        return redirect()
            ->back()
            ->with('success', 'Cập nhật thông tin thành công');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()
            ->back()
            ->with('success', 'Đổi mật khẩu thành công');
    }
}
