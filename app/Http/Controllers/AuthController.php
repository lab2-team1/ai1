<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use OTPHP\TOTP;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    public function register()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.register');
    }

    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Jeśli użytkownik ma aktywne 2FA
            if ($user->two_factor_enabled && $user->otp_secret) {
                Auth::logout(); // Wyloguj z głównej sesji
                $request->session()->put('2fa:user:id', $user->id); // Zapamiętaj user_id w sesji
                return redirect()->route('2fa.verify');
            }

            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Rejestracja użytkownika.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|min:2|max:50|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'required|string|max:50|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|string|min:8|max:255',
            'phone' => 'required|regex:/^(\+48\s?)?(\d{3}[-\s]?){2}\d{3}$/',
        ], [
            'first_name.required' => 'First name is required.',
            'first_name.max' => 'First name cannot be longer than 50 characters.',
            'first_name.regex' => 'First name can only contain letters and spaces.',
            'last_name.required' => 'Last name is required.',
            'last_name.max' => 'Last name cannot be longer than 50 characters.',
            'last_name.regex' => 'Last name can only contain letters and spaces.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email address cannot be longer than 100 characters.',
            'email.unique' => 'This email address is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.max' => 'Password cannot be longer than 255 characters.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Please enter a valid phone number (e.g., +48 123 456 789, 123-456-789, or 123 456 789).',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'admin' => false,
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Konto zostało utworzone pomyślnie!');
    }

    /**
     * Wylogowanie użytkownika.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    /**
     * Formularz do weryfikacji kodu 2FA.
     */
    public function show2faForm(Request $request)
    {
        if (!$request->session()->has('2fa:user:id')) {
            return redirect()->route('login');
        }
        return view('auth.2fa');
    }

    /**
     * Obsługa weryfikacji kodu 2FA.
     */
    public function verify2fa(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|string'
        ]);

        $userId = $request->session()->get('2fa:user:id');
        $user = User::find($userId);

        if (!$user || !$user->otp_secret) {
            return redirect()->route('login')->withErrors(['otp_code' => 'Błąd weryfikacji 2FA.']);
        }

        $otp = TOTP::createFromSecret($user->otp_secret);

        if ($otp->verify($request->input('otp_code'))) {
            // Zaloguj użytkownika i usuń z sesji tymczasowy identyfikator
            Auth::login($user);
            $request->session()->forget('2fa:user:id');
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        } else {
            return back()->withErrors(['otp_code' => 'Nieprawidłowy kod.']);
        }
    }
}
