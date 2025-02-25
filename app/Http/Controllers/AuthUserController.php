<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;



class AuthUserController extends Controller
{
    // login
    public function showLoginUserForm()
    {
        return view('auth.authuser.loginuser');
    }

    // signup
    public function showSignupUserForm()
    {
        return view('auth.authuser.signupuser');
    }

    // forget password
    public function showForgetUserForm()
    {
        return view('auth.authuser.forgetuser');
    }
}
