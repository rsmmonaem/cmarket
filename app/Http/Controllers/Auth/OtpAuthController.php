<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OtpAuthController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Show OTP login form
     */
    public function showLoginForm()
    {
        return view('auth.otp-login');
    }

    /**
     * Send OTP to phone
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|regex:/^[0-9]{11}$/',
        ]);

        $phone = $request->phone;

        // Check if user exists
        $user = User::where('phone', $phone)->first();

        if (!$user) {
            return back()->with('error', 'Phone number not registered.');
        }

        // Generate and send OTP
        $this->otpService->generate($phone);

        return back()->with('success', 'OTP sent to your phone number.')
            ->with('phone', $phone)
            ->with('otp_sent', true);
    }

    /**
     * Verify OTP and login
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'otp' => 'required|string|size:6',
        ]);

        if ($this->otpService->verify($request->phone, $request->otp)) {
            $user = User::where('phone', $request->phone)->first();

            if ($user) {
                Auth::login($user);
                return redirect()->intended('/customer/dashboard');
            }
        }

        return back()->with('error', 'Invalid or expired OTP.');
    }

    /**
     * Resend OTP
     */
    public function resendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        if ($this->otpService->resend($request->phone)) {
            return back()->with('success', 'OTP resent successfully.');
        }

        return back()->with('error', 'Please wait before requesting another OTP.');
    }
}
