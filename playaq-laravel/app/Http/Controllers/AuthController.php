<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ProfessionalProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return Auth::user()->isProfessional() 
                ? redirect()->route('pro.dashboard') 
                : redirect()->route('customer.dashboard');
        }
        return view('auth.login');
    }

    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->isProfessional()) {
                return redirect()->intended(route('pro.dashboard'));
            }

            return redirect()->intended(route('customer.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Show the registration form.
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return Auth::user()->isProfessional() 
                ? redirect()->route('pro.dashboard') 
                : redirect()->route('customer.dashboard');
        }
        return view('auth.register');
    }

    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:customer,professional'],
            'business_name' => ['required_if:role,professional', 'nullable', 'string', 'max:255'],
            'specialty' => ['required_if:role,professional', 'nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($user->isProfessional()) {
            ProfessionalProfile::create([
                'user_id' => $user->id,
                'business_name' => $request->business_name,
                'specialty' => $request->specialty,
                'rating' => 4.9, // Default starting rating
                'completed_jobs' => 0,
            ]);
        }

        Auth::login($user);

        return $user->isProfessional()
            ? redirect()->route('pro.dashboard')
            : redirect()->route('customer.dashboard');
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
