<?php

namespace Modules\Merchant\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Illuminate\Http\Request;

class MerchantRegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('merchant.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'business_type' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'address' => 'required|string',
            'trade_license' => 'nullable|string',
            'nid' => 'nullable|string',
        ]);

        $merchant = Merchant::create([
            'user_id' => auth()->id(),
            'business_name' => $request->business_name,
            'business_type' => $request->business_type,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'trade_license' => $request->trade_license,
            'nid' => $request->nid,
            'status' => 'pending',
        ]);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Merchant application submitted successfully! Please wait for admin approval.');
    }
}
