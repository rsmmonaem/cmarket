<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $categories = \App\Models\Category::active()->whereNull('parent_id')->get();
        $customers = \App\Models\User::role('customer')->latest()->take(100)->get();
        $products = \App\Models\Product::active()->inStock()
            ->with(['category'])
            ->when($request->category, fn($q) => $q->where('category_id', $request->category))
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->paginate(12);

        if ($request->ajax()) {
            return view('admin::pos.partials.product-grid', compact('products'))->render();
        }

        return view('admin::pos.index', compact('categories', 'products', 'customers'));
    }
}
