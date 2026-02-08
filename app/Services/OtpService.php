<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class OtpService
{
    /**
     * Generate and send OTP
     *
     * @param string $phone
     * @return string OTP code
     */
    public function generate(string $phone): string
    {
        // Generate 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store OTP in cache for 5 minutes
        $key = 'otp_' . $phone;
        Cache::put($key, $otp, now()->addMinutes(5));

        // Send SMS (implement your SMS gateway here)
        $this->sendSms($phone, $otp);

        return $otp;
    }

    /**
     * Verify OTP
     *
     * @param string $phone
     * @param string $otp
     * @return bool
     */
    public function verify(string $phone, string $otp): bool
    {
        $key = 'otp_' . $phone;
        $storedOtp = Cache::get($key);

        if (!$storedOtp) {
            return false;
        }

        if ($storedOtp === $otp) {
            // Clear OTP after successful verification
            Cache::forget($key);
            return true;
        }

        return false;
    }

    /**
     * Send SMS via gateway
     *
     * @param string $phone
     * @param string $otp
     * @return void
     */
    protected function sendSms(string $phone, string $otp): void
    {
        // TODO: Implement SMS gateway integration
        // Example for Bangladesh SMS gateways:
        
        // Option 1: Using cURL to send SMS
        /*
        $url = "https://sms-gateway.com/api/send";
        $params = [
            'api_key' => config('services.sms.api_key'),
            'phone' => $phone,
            'message' => "Your CMarket OTP is: {$otp}. Valid for 5 minutes.",
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        */

        // For development: Log OTP instead of sending
        \Log::info("OTP for {$phone}: {$otp}");
    }

    /**
     * Resend OTP
     *
     * @param string $phone
     * @return bool
     */
    public function resend(string $phone): bool
    {
        $key = 'otp_resend_' . $phone;
        
        // Check if resend was attempted recently (prevent spam)
        if (Cache::has($key)) {
            return false;
        }

        // Mark resend attempt (1 minute cooldown)
        Cache::put($key, true, now()->addMinute());

        // Generate new OTP
        $this->generate($phone);

        return true;
    }
}
