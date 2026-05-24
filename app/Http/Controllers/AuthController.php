<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Email atau password tidak sesuai.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // Redirect berdasarkan role
        if ($user->hasRole(Role::ADMIN)) {
            return redirect()->route('dashboard');
        } elseif ($user->hasRole(Role::VERIFIER)) {
            return redirect()->route('verifier.jobseekers.pending-verification');
        } elseif ($user->hasRole(Role::EMPLOYER)) {
            return redirect()->route('perusahaan.dashboard');
        } elseif ($user->hasRole(Role::JOB_SEEKER)) {
            return redirect()->route('lowongan.index');
        }

        return redirect()->route('dashboard');
    }

    public function showRegistrationForm()
    {
        return view('auth.register', [
            'roles' => [
                Role::JOB_SEEKER => 'Pencari Kerja / Masyarakat',
                Role::EMPLOYER   => 'Perusahaan / Employer',
            ],
        ]);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', Rule::in([Role::JOB_SEEKER, Role::EMPLOYER])],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Assign role
        $user->assignRole($data['role']);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login menggunakan akun Anda.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}