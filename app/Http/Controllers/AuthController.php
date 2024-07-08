<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->role == 'owner') {
                Alert::success('Success', 'Login success!');
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->role == 'kasir') {
                Alert::success('Success', 'Login success!');
                return redirect()->intended('/kasir/dashboard');
            }
        }

        Alert::error('Error', 'Mohon Periksa email dan password anda!');
        return redirect('/login')->withInput();
    }

    public function register()
    {
        return view('auth.register');
    }

    public function proses(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6',
        ]);

        $validated['password'] = Hash::make($request['password']);
        $validated['role'] = 'pelanggan';

        $user = user::create($validated);

        Alert::success('Success', 'Register pelanggan berhasil!');
        return redirect('/login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Alert::success('Success', 'Logout berhasil!');
        return redirect('/login');
    }

}
