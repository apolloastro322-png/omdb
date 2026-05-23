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
        ]);

        try {
            $response = $this->authService->login($validated);

            if (!$response) {
                return redirect()->back()->with('error', __('Login failed!'));
            }

            return redirect()->route('movies')->with('success', __('Login successful!'));
        } catch (\Throwable $th) {
            Log::error("Failted login user", [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th->getMessage()
            ]);

            return redirect()->back()->with('error', __('Invalid credentials!'));
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
        ]);

        try {
            $response = $this->authService->register($validated);

            if (!$response) {
                return redirect()->back()->with('error', __('Registration failed!'));
            }

            return redirect()->route('login')->with('success', __('Registration successful!'));
        } catch (\Throwable $th) {
            Log::error("Failted register user", [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th->getMessage()
            ]);

            return redirect()->back()->with('error', __('Registration failed!'));
        }
    }

    public function logout()
    {
        try {
            session()->flush();

            return redirect()->route('login')->with('success', __('You have been logged out!'));
        } catch (\Throwable $th) {
            //throw $th;
            Log::error("Failted logout user", [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th->getMessage()
            ]);
            return redirect()->back()->with('error', __('Something went wrong!'));
        }
    }
}
