<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Contact;
use App\Models\User;

class PageController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function home()
    {
        $stats = [
            'blogs' => Blog::count(),
            'contacts' => Contact::count(),
            'contacts_today' => Contact::whereDate('created_at', today())->count(),
            'users' => User::count(),
        ];

        return view('home', compact('stats'));
    }
}
