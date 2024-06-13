<?php

namespace App\Http\Controllers\RawMaterialInventory;

use App\Http\Controllers\Controller;
use App\Models\RawMaterial;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $filters = Request::all('search');
        $suppliers = Supplier::select('*')
            ->orderBy('updated_at', 'desc')
            ->filter(Request::only('search'))
            ->paginate(10)->withQueryString()
            ->through(fn ($supplier) => [
                'id' => $supplier->id,
                'name' => $supplier->name,
                'nit' => $supplier->nit,
                'email' => $supplier->email,
                'phone_number' => $supplier->phone_number,
                'address' => $supplier->address,
                'description' => $supplier->description,
                'created_at' => $supplier->created_at,
                'updated_at' => $supplier->updated_at
            ]);

        return Inertia::render('Suppliers/Index', [
            'filters' => $filters,
            'suppliers' => $suppliers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $rawMaterials = RawMaterial::select('id', 'name', 'price', 'stock')
            ->orderBy('name', 'asc')->get()->map(function ($material) {
                return [
                    'id' => $material->id,
                    'name' => $material->name,
                    'price' => (float) $material->price,
                    'stock' => $material->stock
                ];
            });

        return Inertia::render('Suppliers/Create', [
            'rawMaterials' => $rawMaterials
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request::validate([
            'name' => 'required|string|max:150',
            'nit' => 'required|integer|min_digits:5|max_digits:20|unique:suppliers,nit',
            'description' => 'nullable|string|max:300',
            'email' => 'required|email:rfc,dns|max:60|unique:suppliers,email',
            'phone_number' => 'required|integer|min_digits:5|max_digits:20',
            'address' => 'string|max:150',
        ]);

        Supplier::create([
            'name' => $validated['name'],
            'nit' => $validated['nit'],
            'description' => $validated['description'] ?? 'Sin descripción',
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'address' => $validated['address']
        ]);

        return redirect()->route('suppliers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier): Response
    {
        $rawMaterials = RawMaterial::select('id', 'name', 'price', 'stock')
            ->orderBy('name', 'asc')->get()->map(function ($material) {
                return [
                    'id' => $material->id,
                    'name' => $material->name,
                    'price' => (float) $material->price,
                    'stock' => $material->stock
                ];
            });

        return Inertia::render('Suppliers/Create', [
            'supplier' => $supplier,
            'rawMaterials' => $rawMaterials
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier): Response
    {
        $rawMaterials = RawMaterial::select('id', 'name', 'price', 'stock')
            ->orderBy('name', 'asc')->get()->map(function ($material) {
                return [
                    'id' => $material->id,
                    'name' => $material->name,
                    'price' => (float) $material->price,
                    'stock' => $material->stock
                ];
            });

        return Inertia::render('Suppliers/Create', [
            'supplier' => $supplier,
            'rawMaterials' => $rawMaterials
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier): RedirectResponse
    {
        $validated = $request::validate([
            'name' => 'required|string|max:150',
            'nit' => 'required|string|max:20|unique:suppliers,nit,' . $supplier['id'],
            'description' => 'nullable|string|max:255',
            'email' => 'required|email|max:60|unique:suppliers,email,' . $supplier['id'],
            'phone_number' => 'string|max:20',
            'address' => 'string|max:150',
        ]);

        $supplier->update($validated);

        return redirect()->route('suppliers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier): RedirectResponse
    {
        $supplier->delete();

        return redirect()->route('suppliers.index');
    }
}
