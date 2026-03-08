<?php

namespace Modules\Merchant\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index()
    {
        $merchant = Auth::user()->merchant;
        return view('merchant.shop.index', compact('merchant'));
    }

    public function update(Request $request)
    {
        $merchant = Auth::user()->merchant;
        $request->validate([
            'business_name' => 'required|string|max:255',
            'business_type' => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        $merchant->update($request->all());

        return back()->with('success', 'Shop configuration updated.');
    }
}
