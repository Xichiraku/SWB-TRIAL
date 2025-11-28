<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $role = $request->role;

        session([
            'user' => [
                'name' => $request->username,
                'username' => $request->username,
                'role' => $role
            ]
        ]);

        // diarahkan sesuai role
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'operator') {
            return redirect()->route('operator.dashboard');
        }

        return redirect()->route('login');
    }

    public function logout(Request $request)
    {
        session()->forget('user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
