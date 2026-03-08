<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FlashDeal;
use App\Models\Product;
use Illuminate\Http\Request;

class FlashDealController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'flash');
        $deals = FlashDeal::where('type', $type)->latest()->paginate(20);
        return view('admin::flash-deals.index', compact('deals', 'type'));
    }

    public function create()
    {
        return view('admin::flash-deals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'type' => 'required|in:flash,daily,featured',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->boolean('is_active', true);

        FlashDeal::create($data);

        return redirect()->route('admin.flash-deals.index')->with('success', 'Deal created.');
    }

    public function edit(FlashDeal $flashDeal)
    {
        return view('admin::flash-deals.edit', compact('flashDeal'));
    }

    public function update(Request $request, FlashDeal $flashDeal)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->boolean('is_active', false);

        $flashDeal->update($data);

        return redirect()->route('admin.flash-deals.index')->with('success', 'Deal updated.');
    }

    public function destroy(FlashDeal $flashDeal)
    {
        $flashDeal->delete();
        return back()->with('success', 'Deal deleted.');
    }
}
