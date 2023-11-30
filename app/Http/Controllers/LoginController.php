<?php

// app/Http/Controllers/LoginController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('Login.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Tetapkan username dan password yang telah ditetapkan sebagai string
        $presetUsername = 'admin';
        $presetPassword = 'admin123!@';

        // Verifikasi username dan password
        if ($request->username != $presetUsername || $request->password != $presetPassword) {
            return view('login')->withErrors(['fail' => 'Username or password is incorrect']);
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
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Check if provided credentials match the valid credentials.
     *
     * @param array $credentials
     * @param array $validCredentials
     * @return bool
     */
    private function checkCredentials(array $credentials, array $validCredentials)
    {
        return $credentials['email'] === $validCredentials['email'] &&
               $credentials['password'] === $validCredentials['password'];
    }
}
