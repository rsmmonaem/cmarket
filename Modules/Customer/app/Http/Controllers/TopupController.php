<?php

namespace Modules\Customer\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Topup;
use Illuminate\Http\Request;

use App\Models\SystemSetting;

class TopupController extends Controller
{
    public function index()
    {
        $topups = Topup::where('user_id', auth()->id())->latest()->paginate(10);
        return view('customer::topup.index', compact('topups'));
    }

    public function create()
    {
        $min_amount = SystemSetting::get('min_topup_amount', 100);
        $methods = explode(',', SystemSetting::get('topup_methods', 'bKash,Nagad,Rocket,Bank Transfer'));
        return view('customer::topup.create', compact('min_amount', 'methods'));
    }

    public function store(Request $request)
    {
        $min_amount = SystemSetting::get('min_topup_amount', 100);
        $methods_list = SystemSetting::get('topup_methods', 'bKash,Nagad,Rocket,Bank Transfer');
        $valid_methods = strtolower(str_replace(' ', '', $methods_list));
        $valid_methods_array = explode(',', $valid_methods);

        $request->validate([
            'amount' => 'required|numeric|min:' . $min_amount,
            'method' => 'required|string', // Validation against specific methods handled below
            'transaction_id' => 'required|string|unique:topups,transaction_id',
            'sender_number' => 'required|string',
        ]);

        // Explicit method check to handle spaces/casing handled in config
        if (!in_array(strtolower(str_replace(' ', '', $request->method)), $valid_methods_array)) {
            return back()->withErrors(['method' => 'Invalid payment method selected.'])->withInput();
        }

        Topup::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'method' => $request->method,
            'transaction_id' => $request->transaction_id,
            'sender_number' => $request->sender_number,
            'status' => 'pending',
        ]);

        return redirect()->route('customer.topup.index')->with('success', 'Top-up request submitted! Admin will verify it soon.');
    }
}
