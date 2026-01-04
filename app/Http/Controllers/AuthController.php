<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Kalau sudah login, redirect ke dashboard sesuai role
        if (session('user')) {
            $role = session('user')['role'];
            return redirect()->route($role === 'admin' ? 'admin.dashboard' : 'operator.dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|in:admin,operator'
        ]);

        // Cari user berdasarkan username SAJA dulu
        $user = User::where('username', $request->username)->first();

        // Cek apakah user ada
        if (!$user) {
            return back()->withErrors([
                'login' => 'Username tidak ditemukan.'
            ])->withInput();
        }

        // Cek apakah role yang dipilih sesuai dengan role user di database
        if ($user->role !== $request->role) {
            return back()->withErrors([
                'login' => 'Role yang dipilih tidak sesuai dengan akun Anda.'
            ])->withInput();
        }

        // Cek password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'login' => 'Password salah.'
            ])->withInput();
        }

        // Login berhasil - simpan ke session
        session([
            'user' => [
                'id' => $user->_id,
                'username' => $user->username,
                'role' => $user->role
            ]
        ]);

        // Redirect ke halaman yang sama dengan pesan sukses dan auto redirect
        return back()->with([
            'login_success' => true,
            'redirect_to' => $user->role === 'admin' ? route('admin.dashboard') : route('operator.dashboard')
        ]);
    }

    public function logout(Request $request)
    {
        session()->forget('user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('logout_success', true);
    }
}