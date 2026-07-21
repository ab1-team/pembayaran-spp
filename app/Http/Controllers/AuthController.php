<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profil;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->withInput(['username' => $request->username])
                ->with('error', 'Username atau password salah');
        }

        Auth::login($user);
        $request->session()->regenerate();
        $profil = Profil::first();
        session()->put('profil', $profil);

        return redirect('/app/dashboard')->with([
            'icon' => 'success',
            'msg'  => 'Selamat datang ' . ($user->nama ?? $user->username ?? 'Pengguna'),
        ]);
    }

    public function logout()
    {
        session()->forget('profil');
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar');
    }
}
