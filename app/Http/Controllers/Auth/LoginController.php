<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Wajib di-import

class LoginController extends Controller
{
    /**
     * Menangani permintaan otentikasi (login).
     */
    public function login(Request $request)
    {
        // 1. Validasi input dari form
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba untuk melakukan otentikasi user
        // Method Auth::attempt() akan otomatis melakukan hashing pada password
        // dan membandingkannya dengan password di database.
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Jika berhasil, regenerate session untuk keamanan
            $request->session()->regenerate();

            // Redirect ke halaman yang dituju sebelumnya, atau ke dashboard jika tidak ada
            return redirect()->intended('dashboard');
        }

        // 3. Jika otentikasi gagal
        // Kembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Menangani permintaan logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Redirect ke halaman login setelah logout
        return redirect('/');
    }
}