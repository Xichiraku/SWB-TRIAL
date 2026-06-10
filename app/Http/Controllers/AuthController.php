<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('user')) {
            $role = session('user')['role'];
            return redirect()->route($role === 'admin' ? 'admin.dashboard' : 'operator.dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'role'     => 'required|in:admin,operator',
        ]);

        // Case-insensitive lookup: MongoDB is case-sensitive by default,
        // so use a regex match to allow login regardless of username case.
        $username = $request->username;
        $user = User::whereRaw([
            'username' => new \MongoDB\BSON\Regex('^' . preg_quote($username, '/') . '$', 'i')
        ])->first();

        if (!$user) {
            return back()->withErrors(['login' => 'Username tidak ditemukan.'])->withInput();
        }

        if ($user->role !== $request->role) {
            return back()->withErrors(['login' => 'Role yang dipilih tidak sesuai dengan akun Anda.'])->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['login' => 'Password salah.'])->withInput();
        }

        session([
            'user' => [
                'id'       => (string) $user->_id,
                'username' => $user->username,
                'role'     => $user->role,
            ],
        ]);

        return back()->with([
            'login_success' => true,
            'redirect_to'   => $user->role === 'admin'
                ? route('admin.dashboard')
                : route('operator.dashboard'),
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