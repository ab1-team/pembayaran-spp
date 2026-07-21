<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterAuthController extends Controller
{
    public function index()
    {
        if (Auth::guard('master')->check()) {
            return redirect()->route('master.dashboard');
        }
        return view('master.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('master')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('master.dashboard'));
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('master')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('master.login');
    }
}
