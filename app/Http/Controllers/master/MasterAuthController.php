<?php

namespace App\Http\Controllers\Master;

use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterAuthController extends \App\Http\Controllers\Controller
{
    public function index()
    {
        return view('master.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'email'    => $request->email,
            'password' => $request->password,
        ];

        if (!Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email or password is incorrect.']);
        }

        $request->session()->regenerate();
        $admin = Auth::guard('admin')->user();

        return redirect()->intended('/master/dashboard')->with([
            'icon' => 'success',
            'msg'  => 'Welcome, ' . ($admin->nama_lengkap ?? 'Master'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('master.login')->with('success', 'You have been signed out.');
    }
}
