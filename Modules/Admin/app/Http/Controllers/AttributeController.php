<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::withCount('values')->latest()->paginate(20);
        return view('admin::attributes.index', compact('attributes'));
    }

    public function create()
    {
        return view('admin::attributes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:attributes,name',
            'values' => 'required|string',
        ]);

        $attribute = Attribute::create(['name' => $request->name]);

        // Create attribute values from comma-separated string
        $values = array_filter(array_map('trim', explode(',', $request->values)));
        foreach ($values as $value) {
            AttributeValue::create(['attribute_id' => $attribute->id, 'value' => $value]);
        }

        return redirect()->route('admin.attributes.index')->with('success', 'Attribute created successfully.');
    }

    public function edit(Attribute $attribute)
    {
        $attribute->load('values');
        return view('admin::attributes.edit', compact('attribute'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:attributes,name,' . $attribute->id,
            'values' => 'required|string',
        ]);

        $attribute->update(['name' => $request->name]);

        // Sync values: delete all, re-create
        $attribute->values()->delete();
        $values = array_filter(array_map('trim', explode(',', $request->values)));
        foreach ($values as $value) {
            AttributeValue::create(['attribute_id' => $attribute->id, 'value' => $value]);
        }

        return redirect()->route('admin.attributes.index')->with('success', 'Attribute updated.');
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->values()->delete();
        $attribute->delete();
        return back()->with('success', 'Attribute deleted.');
    }
}
