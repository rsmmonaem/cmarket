<?php

namespace Modules\Merchant\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $merchant = auth()->user()->merchant;
        $query = Product::where('merchant_id', $merchant->id)->with('category');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->paginate(15);

        return view('merchant.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('merchant.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'cashback_percentage' => 'nullable|numeric|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:2048',
        ]);

        $merchant = auth()->user()->merchant;

        $data = $request->except('image');
        $data['merchant_id'] = $merchant->id;
        $data['status'] = 'pending';

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('merchant.products.index')
            ->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        // Ensure merchant can only edit their own products
        if ($product->merchant_id !== auth()->user()->merchant->id) {
            abort(403);
        }

        $categories = Category::where('is_active', true)->get();
        return view('merchant.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        // Ensure merchant can only update their own products
        if ($product->merchant_id !== auth()->user()->merchant->id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'cashback_percentage' => 'nullable|numeric|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // If product was active/denied, and it's updated, set to update_pending
        if (in_array($product->status, ['active', 'denied'])) {
            $data['status'] = 'update_pending';
        }

        $product->update($data);

        return redirect()->route('merchant.products.index', ['status' => $product->status])
            ->with('success', 'Product updated and submitted for review!');
    }

    public function destroy(Product $product)
    {
        // Ensure merchant can only delete their own products
        if ($product->merchant_id !== auth()->user()->merchant->id) {
            abort(403);
        }

        // Delete image
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('merchant.products.index')
            ->with('success', 'Product deleted successfully!');
    }
}
