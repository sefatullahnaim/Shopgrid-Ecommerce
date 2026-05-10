<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerAuthController extends Controller
{
    public function login()
    {
        return view('website.auth.login');
    }

    public function register()
    {
        return view('website.auth.register');
    }
}
