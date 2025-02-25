<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;



class AuthAdminController extends Controller
{
    // login
    public function showLoginAdminForm()
    {
        return view('auth.authadmin.loginadmin');
    }

    // signup
    public function showSignupAdminForm()
    {
        return view('auth.authadmin.signupadmin');
    }

    // forget password
    public function showForgetAdminForm()
    {
        return view('auth.authadmin.forgetadmin');
    }
}
