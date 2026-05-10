<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'exists:users'],
            'password' => ['required']
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email tidak valid',
            'email.exists' => 'Email tidak terdaftar',
            'password.required' => 'Password wajib diisi'
        ]);

        try {
            $response = $this->authService->login($validated);

            if (!$response) {
                return redirect()->back()->with('error', 'Registrasi gagal');
            }

            return redirect()->route('dashboard')->with('success', 'Registrasi berhasil');
        } catch (\Throwable $th) {
            Log::error("Failted register user", [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th->getMessage()
            ]);

            return redirect()->back()->with('error', 'Kredential salah');
        }
    }

    public function register_process(Request $request)
    {

        $validated = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ]
        ], [
            'name.required' => 'Nama wajib diisi.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',

            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',

            'password.min' => 'Password minimal 8 karakter.',
            'password.letters' => 'Password harus mengandung huruf.',
            'password.mixed' => 'Password harus mengandung huruf besar dan kecil.',
            'password.numbers' => 'Password harus mengandung angka.',
            'password.symbols' => 'Password harus mengandung simbol.',
            'password.uncompromised' => 'Password terlalu lemah atau pernah bocor, gunakan password lain.',
        ]);
        try {
            $response = $this->authService->register($validated);

            if (!$response) {
                return redirect()->back()->with('error', 'Registrasi gagal');
            }

            return redirect()->route('login')->with('success', 'Login berhasil');
        } catch (\Throwable $th) {
            Log::error("Failted register user", [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th->getMessage()
            ]);

            return redirect()->back()->with('error', 'Registrasi gagal');
        }
    }

    public function logout()
    {
        try {
            session()->flush();

            return redirect()->route('login')->with('success', 'Anda telah keluar');
        } catch (\Throwable $th) {
            //throw $th;
            Log::error("Failted register user", [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th->getMessage()
            ]);
            return redirect()->back()->with('error', 'Terjadi keselahan');
        }
    }
}
