<?php

namespace Modules\Ecommerce\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('status', 'active')
            ->where('stock', '>', 0)
            ->with(['category', 'merchant']);

        // Filter by category
        if ($request->has('category')) {
            $category = Category::where('id', $request->category)
                ->orWhere('slug', $request->category)
                ->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Filter by merchant
        if ($request->has('merchant')) {
            $query->where('merchant_id', $request->merchant);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Search
        if ($request->has('q')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%')
                  ->orWhere('description', 'like', '%' . $request->q . '%');
            });
        }

        // Sort
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('ecommerce::products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'merchant', 'reviews.user']);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->take(4)
            ->get();

        return view('ecommerce::products.show', compact('product', 'relatedProducts'));
    }

    public function quickView(Product $product)
    {
        $product->load(['category', 'merchant']);
        $images = is_array($product->images) ? $product->images : (json_decode($product->images, true) ?: []);
        $mainImage = $product->thumbnail ? asset('storage/' . $product->thumbnail) : ($images[0] ? asset('storage/' . $images[0]) : null);
        
        return response()->json([
            'success' => true,
            'product' => $product,
            'main_image' => $mainImage,
            'final_price' => number_format($product->final_price),
            'original_price' => number_format($product->price),
            'show_url' => route('products.show', $product),
            'category_name' => $product->category->name ?? 'Product'
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $products = Product::where('status', 'active')
            ->where(function($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%');
            })
            ->with(['category', 'merchant'])
            ->paginate(12);

        return view('ecommerce::products.search', compact('products', 'query'));
    }
}
