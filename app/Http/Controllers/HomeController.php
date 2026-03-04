<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('status', 'active')
            ->where('type', 'product')
            ->where('stock', '>', 0)
            ->with(['category', 'merchant'])
            ->latest()
            ->take(12)
            ->get();

        $featuredPackages = Product::where('status', 'active')
            ->where('type', 'package')
            ->where('stock', '>', 0)
            ->with(['category', 'merchant'])
            ->latest()
            ->take(4)
            ->get();

        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->withCount('products')
            ->orderBy('sort_order')
            ->take(18)
            ->get();

        return view('welcome', compact('featuredProducts', 'featuredPackages', 'categories'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }
}
