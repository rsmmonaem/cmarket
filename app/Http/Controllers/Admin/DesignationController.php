<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function index()
    {
        $designations = Designation::orderBy('sort_order')->get();
        return view('admin.designations.index', compact('designations'));
    }

    public function create()
    {
        return view('admin.designations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:designations,slug',
            'description' => 'nullable|string',
            'criteria' => 'required|array',
            'criteria.sales_count' => 'nullable|integer|min:0',
            'criteria.referral_count' => 'nullable|integer|min:0',
            'criteria.team_levels' => 'nullable|integer|min:0',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        Designation::create($request->all());

        return redirect()->route('admin.designations.index')
            ->with('success', 'Designation created successfully.');
    }

    public function edit(Designation $designation)
    {
        return view('admin.designations.edit', compact('designation'));
    }

    public function update(Request $request, Designation $designation)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:designations,slug,' . $designation->id,
            'description' => 'nullable|string',
            'criteria' => 'required|array',
            'criteria.sales_count' => 'nullable|integer|min:0',
            'criteria.referral_count' => 'nullable|integer|min:0',
            'criteria.team_levels' => 'nullable|integer|min:0',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $designation->update($request->all());

        return redirect()->route('admin.designations.index')
            ->with('success', 'Designation updated successfully.');
    }

    public function destroy(Designation $designation)
    {
        $designation->delete();
        return redirect()->route('admin.designations.index')
            ->with('success', 'Designation deleted successfully.');
    }
}
