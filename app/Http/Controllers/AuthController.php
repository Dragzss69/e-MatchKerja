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
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }
            if ($user->hasRole('perusahaan')) {
                return redirect()->route('perusahaan.dashboard');
            }
            if ($user->hasRole('job_seeker')) {
                return redirect()->route('pencari-kerja.dashboard');
            }
            if ($user->hasRole('verifier')) {
                return redirect()->route('pengajuan-bantuan.index');
            }
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
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
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->hasRole('employer')) {
            return redirect()->route('perusahaan.dashboard');
        }
        if ($user->hasRole('job_seeker')) {
            return redirect()->route('pencari-kerja.dashboard');
        }
        if ($user->hasRole('verifier')) {
            return redirect()->route('pengajuan-bantuan.index');
        }

        return redirect()->route('home');
    }

    public function showRegistrationForm()
    {
        return view('auth.register', [
            'roles' => [
                'job_seeker' => 'Pencari Kerja / Masyarakat',
                'perusahaan' => 'Perusahaan / Employer',
            ],
        ]);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['job_seeker', 'perusahaan'])],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole($data['role']);

        Auth::login($user);

        if ($data['role'] == 'perusahaan') {
            return redirect()->route('perusahaan.dashboard');
        }
        return redirect()->route('pencari-kerja.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }
}