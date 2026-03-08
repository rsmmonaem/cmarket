<?php

namespace Modules\Affiliate\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Affiliate;
use App\Models\AffiliateLink;
use App\Models\AffiliateClick;
use App\Models\AffiliateCommission;
use App\Models\AffiliateLink as Link;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class AffiliateController extends Controller
{
    /**
     * Track affiliate link clicks and redirect to product page
     */
    public function track(Request $request, $code)
    {
        $link = AffiliateLink::where('code', $code)->with('product')->firstOrFail();

        // Record the click
        AffiliateClick::create([
            'link_id'    => $link->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referrer'   => $request->header('referer'),
        ]);

        $link->increment('clicks');

        // Store affiliate info in cookie (30 days)
        $cookieValue = json_encode([
            'affiliate_id' => $link->affiliate_id,
            'link_id'      => $link->id,
            'product_id'   => $link->product_id,
        ]);

        return redirect()->route('products.show', $link->product_id)
            ->withCookie(cookie('cmarket_affiliate', $cookieValue, 60 * 24 * 30));
    }

    /**
     * Affiliate landing/registration page (public)
     */
    public function register()
    {
        return view('affiliate.register');
    }

    /**
     * Affiliate dashboard (auth required + must have affiliate record)
     */
    public function dashboard()
    {
        $user      = auth()->user();
        $affiliate = $user->affiliate ?? Affiliate::create(['user_id' => $user->id, 'status' => 'active']);

        $totalEarnings     = AffiliateCommission::where('affiliate_id', $affiliate->id)
            ->where('status', 'approved')->sum('commission_amount');
        $pendingEarnings   = AffiliateCommission::where('affiliate_id', $affiliate->id)
            ->where('status', 'pending')->sum('commission_amount');
        $totalClicks       = AffiliateLink::where('affiliate_id', $affiliate->id)->sum('clicks');
        $totalConversions  = AffiliateCommission::where('affiliate_id', $affiliate->id)->count();
        $conversionRate    = $totalClicks > 0 ? round(($totalConversions / $totalClicks) * 100, 2) : 0;

        $recentCommissions = AffiliateCommission::where('affiliate_id', $affiliate->id)
            ->with('order')->latest()->take(5)->get();

        $topLinks = AffiliateLink::where('affiliate_id', $affiliate->id)
            ->with('product')->orderByDesc('clicks')->take(5)->get();

        return view('affiliate.dashboard', compact(
            'affiliate', 'totalEarnings', 'pendingEarnings',
            'totalClicks', 'totalConversions', 'conversionRate',
            'recentCommissions', 'topLinks'
        ));
    }

    /**
     * My affiliate links list
     */
    public function links()
    {
        $affiliate = auth()->user()->affiliate;
        if (!$affiliate) return redirect()->route('affiliate.dashboard');

        $links = AffiliateLink::where('affiliate_id', $affiliate->id)
            ->with('product')->latest()->paginate(20);

        $products = Product::where('status', 'active')->orderBy('name')->get();

        return view('affiliate.links', compact('links', 'products', 'affiliate'));
    }

    /**
     * Generate a new affiliate link for a product
     */
    public function generateLink(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $affiliate = auth()->user()->affiliate;
        if (!$affiliate) {
            return back()->with('error', 'Affiliate account not found.');
        }

        // Check if link for this product already exists
        $existing = AffiliateLink::where('affiliate_id', $affiliate->id)
            ->where('product_id', $request->product_id)->first();

        if ($existing) {
            return back()->with('info', 'You already have a link for this product.');
        }

        AffiliateLink::create([
            'affiliate_id' => $affiliate->id,
            'product_id'   => $request->product_id,
        ]);

        return back()->with('success', 'Affiliate link generated successfully!');
    }

    /**
     * Commissions history
     */
    public function commissions(Request $request)
    {
        $affiliate = auth()->user()->affiliate;
        if (!$affiliate) return redirect()->route('affiliate.dashboard');

        $status = $request->get('status', 'all');
        $query  = AffiliateCommission::where('affiliate_id', $affiliate->id)->with('order');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $commissions   = $query->latest()->paginate(20);
        $totalApproved = AffiliateCommission::where('affiliate_id', $affiliate->id)
            ->where('status', 'approved')->sum('commission_amount');
        $totalPending  = AffiliateCommission::where('affiliate_id', $affiliate->id)
            ->where('status', 'pending')->sum('commission_amount');

        return view('affiliate.commissions', compact('commissions', 'status', 'totalApproved', 'totalPending'));
    }

    /**
     * Analytics — click trends by link
     */
    public function analytics()
    {
        $affiliate = auth()->user()->affiliate;
        if (!$affiliate) return redirect()->route('affiliate.dashboard');

        $links = AffiliateLink::where('affiliate_id', $affiliate->id)
            ->with(['product', 'clicks'])
            ->withCount('clicks')
            ->orderByDesc('clicks_count')
            ->get();

        return view('affiliate.analytics', compact('affiliate', 'links'));
    }

    /**
     * Show withdrawal request form
     */
    public function withdraw()
    {
        $user      = auth()->user();
        $affiliate = $user->affiliate;
        if (!$affiliate) return redirect()->route('affiliate.dashboard');

        $availableBalance = \App\Models\AffiliateCommission::where('affiliate_id', $affiliate->id)
            ->where('status', 'approved')->sum('commission_amount');

        $withdrawals = \App\Models\Withdrawal::where('user_id', $user->id)
            ->where('wallet_type', 'commission')
            ->latest()->paginate(10);

        return view('affiliate.withdraw', compact('affiliate', 'availableBalance', 'withdrawals'));
    }

    /**
     * Submit withdrawal request
     */
    public function requestWithdrawal(\Illuminate\Http\Request $request)
    {
        $affiliate = auth()->user()->affiliate;
        if (!$affiliate) return redirect()->route('affiliate.dashboard');

        $availableBalance = \App\Models\AffiliateCommission::where('affiliate_id', $affiliate->id)
            ->where('status', 'approved')->sum('commission_amount');

        $request->validate([
            'amount'          => "required|numeric|min:100|max:{$availableBalance}",
            'bank_name'       => 'required|string|max:100',
            'account_name'    => 'required|string|max:100',
            'account_number'  => 'required|string|max:50',
        ]);

        // Check if there's a pending withdrawal already
        $pending = \App\Models\Withdrawal::where('user_id', auth()->id())
            ->where('wallet_type', 'commission')
            ->where('status', 'pending')->first();

        if ($pending) {
            return back()->with('error', 'You already have a pending withdrawal request.');
        }

        \App\Models\Withdrawal::create([
            'user_id'        => auth()->id(),
            'wallet_type'    => 'commission',
            'amount'         => $request->amount,
            'bank_name'      => $request->bank_name,
            'account_name'   => $request->account_name,
            'account_number' => $request->account_number,
            'status'         => 'pending',
            'notes'          => 'Affiliate commission withdrawal',
        ]);

        return back()->with('success', 'Withdrawal request submitted! Admin will process within 2-3 business days.');
    }
}
