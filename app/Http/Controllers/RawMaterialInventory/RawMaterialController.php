<?php

namespace App\Http\Controllers\RawMaterialInventory;

use App\Http\Controllers\Controller;
use App\Models\RawMaterial;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;

class RawMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $filters = Request::all('search');
        $rawMaterials = RawMaterial::select('*')
            ->orderBy('updated_at', 'desc')
            ->filter(Request::only('search'))
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($material) => [
                'id' => $material->id,
                'name' => $material->name,
                'price' => $material->price,
                'stock' => $material->stock,
                'description' => $material->description,
                'image' => $material->image,
                'created_at' => $material->created_at,
                'updated_at' => $material->updated_at
            ]);

        return Inertia::render('RawMaterials/Index', [
            'filters' => $filters,
            'rawMaterials' => $rawMaterials
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $suppliers = Supplier::select('name')
            ->orderBy('name', 'asc')
            ->get();

        return Inertia::render('RawMaterials/Create', [
            'suppliers' => $suppliers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request::validate([
            'name' => 'required|string|max:150',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:300',
        ]);

        RawMaterial::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'stock' => 0,
            'description' => $validated['description'] ?? 'Sin descripción'
        ]);

        return redirect()->route('raw-materials.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(RawMaterial $rawMaterial): Response
    {
        $suppliers = Supplier::select('name')
            ->orderBy('name', 'asc')
            ->get();

        return Inertia::render('RawMaterials/Create', [
            'rawMaterial' => $rawMaterial,
            'suppliers' => $suppliers
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RawMaterial $rawMaterial): Response
    {
        $suppliers = Supplier::select('name')
            ->orderBy('name', 'asc')
            ->get();

        return Inertia::render('RawMaterials/Create', [
            'rawMaterial' => $rawMaterial,
            'suppliers' => $suppliers
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RawMaterial $rawMaterial): RedirectResponse
    {
        $validated = $request::validate([
            'name' => 'required|string|max:150',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:300',
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
