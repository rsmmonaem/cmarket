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

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return back()->withErrors([
                'phone' => 'The provided credentials do not match our records.',
            ])->onlyInput('phone');
        }

        // Check if account is locked
        if ($user->isLocked()) {
            $minutes = now()->diffInMinutes($user->locked_until);
            return back()->withErrors([
                'phone' => "Your account is locked due to multiple failed attempts. Please try again in {$minutes} minutes.",
            ]);
        }

        if (Hash::check($request->password, $user->password)) {
            // Credentials correct, now check if OTP is required
            // For this ecosystem, we'll make OTP mandatory for extra security
            $otp = $user->generateOtp();
            
            // Log attempt info
            $user->update([
                'ip_address' => $request->ip(),
                'device_info' => $request->userAgent(),
            ]);

            Session::put('auth_user_id', $user->id);
            Session::put('auth_remember', $request->filled('remember'));

            // In production, send SMS. For now, we flash it.
            return redirect()->route('auth.otp.verify.form')
                ->with('success', 'Credentials verified. Please enter the OTP sent to your phone.')
                ->with('otp_debug', "DEBUG OTP: {$otp}");
        }

        // Credentials incorrect
        $user->incrementLoginAttempts();
        
        return back()->withErrors([
            'phone' => 'The provided credentials do not match our records.',
        ])->onlyInput('phone');
    }

    public function showOtpVerifyForm()
    {
        if (!Session::has('auth_user_id')) {
            return redirect()->route('login');
        }
        return view('auth.otp-verify');
    }

    public function verifyLoginOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $userId = Session::get('auth_user_id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->verifyOtp($request->otp)) {
            Auth::login($user, Session::get('auth_remember', false));
            $request->session()->regenerate();
            
            Session::forget(['auth_user_id', 'auth_remember']);

            // Log device/login
            $this->logDevice($user, $request);

            // Redirect based on role
            return $this->authenticated($request, $user);
        }

        return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->status === 'suspended') {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'phone' => 'Your account has been suspended. Please contact support.',
            ]);
        }

        if ($user->hasRole('super-admin') || $user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('merchant')) {
            return redirect()->route('merchant.dashboard');
        } elseif ($user->hasRole('rider')) {
            return redirect()->route('rider.dashboard');
        }

        return redirect()->route('customer.dashboard');
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
