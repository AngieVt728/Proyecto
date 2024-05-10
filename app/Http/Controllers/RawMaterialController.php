<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class RawMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $raw_materials = RawMaterial::all();

        return Inertia::render('RawMaterials/Index', ['raw_materials' => $raw_materials]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('RawMaterials/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
        ]);

        RawMaterial::create($validated);

        return redirect()->route('raw-materials.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(RawMaterial $rawMaterial): Response
    {
        return Inertia::render('RawMaterials/Show', ['raw_material' => $rawMaterial]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RawMaterial $rawMaterial): Response
    {
        return Inertia::render('RawMaterials/Edit', ['raw_material' => $rawMaterial]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RawMaterial $rawMaterial): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
        ]);

        $rawMaterial->update($validated);

        return redirect()->route('raw-materials.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RawMaterial $rawMaterial): RedirectResponse
    {
        $rawMaterial->delete();

        return redirect()->route('raw-materials.index');
    }
}
