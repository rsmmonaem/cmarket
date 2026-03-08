<?php

namespace Modules\Rider\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rider;
use Illuminate\Http\Request;

class RiderRegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('rider.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'vehicle_type' => 'required|string',
            'vehicle_number' => 'required|string',
            'license_number' => 'nullable|string',
            'nid' => 'nullable|string',
            'address' => 'required|string',
            'emergency_contact' => 'nullable|string',
        ]);

        $rider = Rider::create([
            'user_id' => auth()->id(),
            'vehicle_type' => $request->vehicle_type,
            'vehicle_number' => $request->vehicle_number,
            'license_number' => $request->license_number,
            'nid' => $request->nid,
            'address' => $request->address,
            'emergency_contact' => $request->emergency_contact,
            'status' => 'pending',
        ]);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Rider application submitted successfully! Please wait for admin approval.');
    }
}
