<?php

    namespace App\Http\Controllers\Author;

    use App\Http\Controllers\Controller;
    use Exception;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Storage;

    class AuthorProfileController extends Controller
    {

        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            $user = auth()->user();

            return view('admin.profile.index', compact('user'));
        }

        public function update(Request $request)
        {
            try {
                $user = Auth::user();

                $request->validate([
                    'username' => 'required|string|max:50|unique:users,username,' . $user->user_id . ',user_id',
                    'email' => 'required|email|max:100|unique:users,email,' . $user->user_id . ',user_id',
                    'description' => 'nullable|string|max:150',
                    'phone' => 'nullable|string|max:15',
                    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);

                $user->username = $request->input('username');
                $user->description = $request->input('description');
                $user->email = $request->input('email');
                $user->phone = $request->input('phone');

                if ($request->hasFile('image')) {
                    if ($user->image) {
                        Storage::delete('public/' . $user->image);
                    }

                    $imagePath = $request->file('image')
                        ->store('public/profile_images');
                    $user->image = str_replace('public/', '', $imagePath);
                }

                $user->save();

                return redirect()
                    ->route('admin.profile')
                    ->with('success', 'Profile updated successfully!');
            } catch (Exception $e) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error',
                        'An error occurred: ' . $e->getMessage());
            }
        }

    }
