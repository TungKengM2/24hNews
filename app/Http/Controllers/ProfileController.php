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

    public function requestAuthorRole(Request $request)
    {
        $existingRequest = Approval::where('type', 'role_upgrade')
            ->where('status', 'pending')
            ->where('requested_role', 'author')
            ->where('user_id', auth()->id())
            ->exists();

        if ($existingRequest) {
            return redirect()->route('profile.edit')->with('error', 'You have already submitted a request.');
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

        return redirect()->route('profile.edit')->with('status', 'Your request has been submitted successfully.');
    }
}
