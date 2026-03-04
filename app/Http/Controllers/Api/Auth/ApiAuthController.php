<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    /**
     * Login via Phone & Password -> Sends OTP
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('phone', $request->phone)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            if ($user) $user->incrementLoginAttempts();
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }

        if ($user->isLocked()) {
            $minutes = now()->diffInMinutes($user->locked_until);
            return response()->json(['message' => "Account is locked. Try again in {$minutes} minutes."], 403);
        }

        // Generate OTP for API multi-layer security
        $otp = $user->generateOtp();

        // Log attempt
        $user->update([
            'ip_address' => $request->ip(),
            'device_info' => $request->header('User-Agent'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'OTP sent to your phone.',
            'phone' => $user->phone,
            'otp_debug' => $otp // REMOVE IN PRODUCTION
        ]);
    }

    /**
     * Verify OTP and return Token
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'otp' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        if ($user->verifyOtp($request->otp)) {
            // Success! Generate Token
            $token = $user->createToken('auth_token')->plainTextToken;

            // Log Device
            UserDevice::create([
                'user_id' => $user->id,
                'device_info' => $request->header('User-Agent'),
                'ip_address' => $request->ip(),
                'last_login' => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'status' => $user->status,
                ]
            ]);
        }

        return response()->json(['message' => 'Invalid or expired OTP.'], 401);
    }

    /**
     * Logout (Revoke Token)
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully.']);
    }
}
