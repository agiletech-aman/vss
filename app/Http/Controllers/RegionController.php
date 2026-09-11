<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;

class RegionController extends Controller
{
    /**
     * Display all regions
     * Permission: view_regions
     */
    public function index()
    {
        $this->authorize('view_regions');

        $regions = Region::all();
        return view('admin.region.all_region', compact('regions'));
    }

    /**
     * Show create region form
     * Permission: manage_regions
     */
    public function create()
    {
        $this->authorize('manage_regions');

        return view('admin.region.add_region');
    }

    /**
     * Store new region
     * Permission: manage_regions
     */
    public function store(Request $request)
    {
        $this->authorize('manage_regions');

        $request->validate([
            'name' => 'required|unique:regions,name',
        ]);

        Region::create([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('all.region')
            ->with('success', 'Region added successfully.');
    }

    /**
     * Show edit form
     * Permission: manage_regions
     */
    public function edit($id)
    {
        $this->authorize('manage_regions');

        $region = Region::findOrFail($id);
        return view('admin.region.edit_region', compact('region'));
    }

    /**
     * Update region
     * Permission: manage_regions
     */
    public function update(Request $request, $id)
    {
        $this->authorize('manage_regions');

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $region = Region::findOrFail($id);
        $region->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('all.region')
            ->with('success', 'Region updated successfully!');
    }

    /**
     * Delete region
     * Permission: manage_regions
     */
    public function destroy($id)
    {
        $this->authorize('manage_regions');

        $region = Region::findOrFail($id);
        $region->delete();

        return redirect()
            ->route('all.region')
            ->with('success', 'Region deleted successfully!');
    }
}
