<?php

    namespace App\Http\Controllers;

    use App\Models\Approval;
    use Illuminate\Http\Request;

    class ProfileController extends Controller
    {

        /**
         * Show the form for editing the profile.
         *
         * @return \Illuminate\View\View
         */
        public function edit()
        {
            return view('client.profile.layouts.home');
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
                'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
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

    }
