<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Merchant;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $imageService;

    public function __construct(ImageUploadService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $products = Product::with(['category', 'merchant'])->latest()->paginate(20);
        return view('admin::products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::active()->whereNull('parent_id')->with('children.children')->get();
        $merchants = Merchant::where('status', 'approved')->get();
        return view('admin::products.create', compact('categories', 'merchants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'merchant_id' => 'nullable|exists:merchants,id',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:product,package',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|unique:products,sku',
            'cashback_percentage' => 'nullable|numeric|min:0|max:100',
            'status' => 'required|in:active,inactive,draft',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:1000',
            'is_featured' => 'boolean',
            'is_flash_deal' => 'boolean',
            'flash_deal_start' => 'nullable|date',
            'flash_deal_end' => 'nullable|date|after:flash_deal_start',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'product_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except(['product_images', 'thumbnail', 'attributes', 'variations']);
        
        // Single Thumbnail
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->imageService->upload($request->file('thumbnail'), 'products');
        }

        // Multiple Gallery Images
        $images = [];
        if ($request->hasFile('product_images')) {
            foreach ($request->file('product_images') as $image) {
                $images[] = $this->imageService->upload($image, 'products');
            }
        }
        $data['images'] = $images;

        // Attributes & Variations JSON Decoding
        // NOTE: $request->attributes is a reserved Symfony ParameterBag — must use input()
        if ($request->filled('attributes')) {
            $data['attributes'] = json_decode($request->input('attributes'), true) ?: [];
        }
        
        if ($request->filled('variations')) {
            $variations = json_decode($request->input('variations'), true) ?: [];
            
            // Clean up the variations data — ensure correct types
            foreach($variations as &$v) {
                $v['price'] = floatval($v['price'] ?? 0);
                $v['stock'] = intval($v['stock'] ?? 0);
            }
            $data['variations'] = $variations;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'merchant', 'reviews']);
        return view('admin::products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        $merchants = Merchant::where('status', 'approved')->get();
        return view('admin::products.edit', compact('product', 'categories', 'merchants'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'merchant_id' => 'nullable|exists:merchants,id',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:product,package',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'cashback_percentage' => 'nullable|numeric|min:0|max:100',
            'status' => 'required|in:active,inactive,draft,pending,denied,update_pending',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:1000',
            'is_featured' => 'boolean',
            'is_flash_deal' => 'boolean',
            'flash_deal_start' => 'nullable|date',
            'flash_deal_end' => 'nullable|date|after:flash_deal_start',
            'admin_feedback' => 'nullable|string|max:1000',
            'product_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('product_images');

        $images = $product->images ?: [];
        if ($request->hasFile('product_images')) {
            foreach ($request->file('product_images') as $image) {
                $images[] = $this->imageService->upload($image, 'products');
            }
        }
        $data['images'] = $images;

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->images) {
            foreach ($product->images as $image) {
                $this->imageService->delete($image);
            }
        }
        $product->delete();
        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
