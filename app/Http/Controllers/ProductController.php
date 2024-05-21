<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\RawMaterial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Products/Index', [
            'products' => Product::select('*')->orderBy('updated_at', 'desc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Products/Create', [
            'rawMaterials' => RawMaterial::select('id', 'name', 'price', 'stock')
                ->orderBy('name', 'asc')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:300',
            'price' => 'required|numeric|min:0',
            'rawMaterials' => 'nullable|array',
            'rawMaterials.*.id' => 'exists:raw_materials,id',
            'rawMaterials.*.quantity' => 'required_with:rawMaterials|integer|min:1'
        ]);

        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? 'Sin descripción',
            'price' => $validated['price'],
        ]);

        if (isset($validated['rawMaterials']) && is_array($validated['rawMaterials'])) {
            $rawMaterials = [];
            foreach ($validated['rawMaterials'] as $rawMaterial) {
                $rawMaterials[$rawMaterial['id']] = ['quantity' => $rawMaterial['quantity']];
            }
            $product->rawMaterials()->attach($rawMaterials);
        }

        return redirect()->route('products.index');
    }



    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $raw_materials = RawMaterial::all()->sortBy('name');

        return Inertia::render('Products/Create', ['product' => $product, 'raw_materials' => $raw_materials]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $raw_materials = RawMaterial::all()->sortBy('name');
        $raw_materials_product = $product->rawMaterials()->get();

        return Inertia::render('Products/Create', [
            'product' => $product,
            'raw_materials_product' => $raw_materials_product,
            'raw_materials' => $raw_materials
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
        ]);

        $product->update($validated);

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('products.index');
    }
}
