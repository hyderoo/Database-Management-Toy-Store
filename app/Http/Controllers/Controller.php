<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function viewLogin()
    {
        return view('admin.login');
    }

    public function auth(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Tetapkan username dan password yang telah ditetapkan sebagai string
        $presetUsername = 'admin';
        $presetPassword = 'admin123';

        // Verifikasi username dan password
        if ($request->username != $presetUsername || $request->password != $presetPassword) {
            return view('admin.login')->withErrors(['fail' => 'Username or password is incorrect']);
        }

        // Tetapkan data user ke dalam session (sesuaikan dengan kebutuhan)
        $userData = [
            'username' => $presetUsername,
            'password' => $presetPassword
            // Tambahkan data user lainnya sesuai kebutuhan
        ];

        session(['user' => $userData]);

        // Redirect sesuai dengan kebutuhan
        return redirect('/dashboard');
    }
    public function logout(Request $request)
    {
        // Clear user data from the session
        $request->session()->forget('user');

        // Redirect to the login page
        return redirect('/login');
    }
}