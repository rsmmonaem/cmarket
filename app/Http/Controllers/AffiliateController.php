<?php

namespace App\Http\Controllers;

use App\Models\AffiliateLink;
use App\Models\AffiliateClick;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class AffiliateController extends Controller
{
    /**
     * Track affiliate link clicks and redirect to product
     */
    public function track(Request $request, $code)
    {
        $link = AffiliateLink::where('code', $code)->with('product')->firstOrFail();

        // Record the click
        AffiliateClick::create([
            'link_id' => $link->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referrer' => $request->header('referer'),
        ]);

        // Increment click count
        $link->increment('clicks');

        // Store affiliate info in cookie for 30 days
        $cookieValue = json_encode([
            'affiliate_id' => $link->affiliate_id,
            'link_id' => $link->id,
            'product_id' => $link->product_id
        ]);

        return redirect()->route('products.show', $link->product_id)
            ->withCookie(cookie('cmarket_affiliate', $cookieValue, 60 * 24 * 30));
    }

    /**
     * Main affiliate dashboard (future implementation)
     */
    public function index()
    {
        return view('affiliate.dashboard');
    }
}
