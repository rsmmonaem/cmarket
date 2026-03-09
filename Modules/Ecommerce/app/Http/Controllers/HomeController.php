<?php

namespace Modules\Ecommerce\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Banners
        $mainBanners = \App\Models\Banner::where('position', 'main_banner')->where('is_active', true)->orderBy('sort_order')->get();
        $midBanners = \App\Models\Banner::where('position', 'mid_banner')->where('is_active', true)->orderBy('sort_order')->get();
        $popupBanner = \App\Models\Banner::where('position', 'popup_banner')->where('is_active', true)->first();

        // Flash Deals
        $flashDeals = Product::active()
            ->where('is_flash_deal', true)
            ->where('flash_deal_start', '<=', now())
            ->where('flash_deal_end', '>=', now())
            ->where('stock', '>', 0)
            ->with(['category', 'merchant'])
            ->take(8)
            ->get();

        // Featured Products
        $featuredProducts = Product::active()
            ->where('is_featured', true)
            ->where('stock', '>', 0)
            ->with(['category', 'merchant'])
            ->latest()
            ->take(12)
            ->get();

        // New Arrivals
        $newArrivals = Product::active()
            ->where('stock', '>', 0)
            ->with(['category', 'merchant'])
            ->latest()
            ->take(8)
            ->get();

        // Categories with products
        $popularCategories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->withCount('products')
            ->orderBy('products_count', 'desc')
            ->take(10)
            ->get();

        // Top Merchants
        $topMerchants = \App\Models\Merchant::where('status', 'approved')
            ->withCount('products')
            ->orderBy('products_count', 'desc')
            ->take(6)
            ->get();

        return view('ecommerce::welcome', compact(
            'mainBanners', 'midBanners', 'popupBanner', 
            'flashDeals', 'featuredProducts', 'newArrivals',
            'popularCategories', 'topMerchants'
        ));
    }

    public function categories()
    {
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->with(['children' => function($q) {
                $q->where('is_active', true)->with('children');
            }])
            ->withCount('products')
            ->get();

        return view('ecommerce::categories.index', compact('categories'));
    }

    public function about()
    {
        return view('ecommerce::pages.about');
    }

    public function contact()
    {
        return view('ecommerce::pages.contact');
    }

    public function merchants()
    {
        $merchants = \App\Models\Merchant::where('status', 'approved')
            ->withCount('products')
            ->orderBy('products_count', 'desc')
            ->get();

        return view('ecommerce::merchants.index', compact('merchants'));
    }
}
