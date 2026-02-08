<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDevice;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:users,phone|regex:/^01[0-9]{9}$/',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'free',
        ]);

        // Assign customer role
        $user->assignRole('customer');

        // Create main wallet
        Wallet::create([
            'user_id' => $user->id,
            'wallet_type' => 'main',
            'is_locked' => false,
        ]);

        // Log device
        $this->logDevice($user, $request);

        // Auto login
        Auth::login($user);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Registration successful! Welcome to CMarket.');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'phone' => $request->phone,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Check if user is suspended
            if ($user->status === 'suspended') {
                Auth::logout();
                return back()->withErrors([
                    'phone' => 'Your account has been suspended. Please contact support.',
                ]);
            }

            // Log device
            $this->logDevice($user, $request);

            // Redirect based on role
            if ($user->hasRole('super-admin') || $user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('merchant')) {
                return redirect()->route('merchant.dashboard');
            } elseif ($user->hasRole('rider')) {
                return redirect()->route('rider.dashboard');
            }

            return redirect()->route('customer.dashboard');
        }

        return back()->withErrors([
            'phone' => 'The provided credentials do not match our records.',
        ])->onlyInput('phone');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Logged out successfully.');
    }

    protected function logDevice(User $user, Request $request)
    {
        UserDevice::create([
            'user_id' => $user->id,
            'device_info' => $request->userAgent(),
            'ip_address' => $request->ip(),
            'last_login' => now(),
        ]);
    }

    // OTP Methods (to be implemented with SMS service)
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|regex:/^01[0-9]{9}$/',
        ]);

        // Generate OTP
        $otp = rand(100000, 999999);

        // Store OTP in session
        Session::put('otp', $otp);
        Session::put('otp_phone', $request->phone);
        Session::put('otp_expires', now()->addMinutes(5));

        // TODO: Send OTP via SMS service
        // For now, we'll just flash it (remove in production)
        return back()->with('otp_sent', "OTP sent to {$request->phone}. OTP: {$otp}");
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'otp' => 'required|numeric|digits:6',
        ]);

        $storedOtp = Session::get('otp');
        $storedPhone = Session::get('otp_phone');
        $otpExpires = Session::get('otp_expires');

        if (!$storedOtp || !$storedPhone || !$otpExpires) {
            return back()->withErrors(['otp' => 'OTP not found. Please request a new one.']);
        }

        if (now()->greaterThan($otpExpires)) {
            Session::forget(['otp', 'otp_phone', 'otp_expires']);
            return back()->withErrors(['otp' => 'OTP has expired. Please request a new one.']);
        }

        if ($request->otp != $storedOtp || $request->phone != $storedPhone) {
            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }

        // OTP verified
        Session::forget(['otp', 'otp_phone', 'otp_expires']);
        Session::put('otp_verified', true);

        return back()->with('success', 'Phone number verified successfully!');
    }
}
