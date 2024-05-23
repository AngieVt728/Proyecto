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
        $products = Product::select('*')
            ->orderByRaw('GREATEST(products.updated_at, (SELECT MAX(updated_at) FROM product_raw_material WHERE product_raw_material.product_id = products.id)) DESC')
            ->get();

        return Inertia::render('Products/Index', [
            'products' => $products
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

        return Inertia::render('Products/Create', [
            'rawMaterials' => $rawMaterials
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
            'rawMaterials.*.quantity' => 'required_with:rawMaterials|integer|min:1',
            'rawMaterials.*.cost' => 'required_with:rawMaterials|numeric|min:1'
        ]);

        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? 'Sin descripción',
            'price' => $validated['price'],
            'stock' => 0
        ]);

        if (isset($validated['rawMaterials']) && is_array($validated['rawMaterials'])) {
            $rawMaterials = [];
            foreach ($validated['rawMaterials'] as $rawMaterial) {
                $rawMaterials[$rawMaterial['id']] =
                    [
                        'quantity' => $rawMaterial['quantity'],
                        'cost' => $rawMaterial['cost']
                    ];
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
        $rawMaterials = RawMaterial::select('id', 'name', 'price', 'stock')
            ->orderBy('name', 'asc')->get()->map(function ($material) {
                return [
                    'id' => $material->id,
                    'name' => $material->name,
                    'price' => (float) $material->price,
                    'stock' => $material->stock
                ];
            });
        $productRawMaterial = $product->rawMaterials()
            ->withPivot('raw_material_id', 'quantity', 'cost')
            ->get();

        return Inertia::render('Products/Create', [
            'rawMaterials' => $rawMaterials,
            'product' => $product,
            'productRawMaterial' => $productRawMaterial
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
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
        $productRawMaterial = $product->rawMaterials()
            ->withPivot('quantity', 'cost')
            ->get();

        $formattedRawMaterials = [];
        foreach ($productRawMaterial as $rawMaterial) {
            $formattedRawMaterials[] = [
                'id' => $rawMaterial->pivot->raw_material_id,
                'quantity' => $rawMaterial->pivot->quantity,
                'cost' => (float) number_format($rawMaterial->pivot->cost, 2),
                'selected' => true,
            ];
        }

        return Inertia::render('Products/Create', [
            'rawMaterials' => $rawMaterials,
            'product' => $product,
            'productRawMaterial' => $formattedRawMaterials
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:300',
            'price' => 'required|numeric|min:0',
            'rawMaterials' => 'nullable|array',
            'rawMaterials.*.id' => 'exists:raw_materials,id',
            'rawMaterials.*.quantity' => 'required_with:rawMaterials|integer|min:1',
            'rawMaterials.*.cost' => 'required_with:rawMaterials|numeric|min:1'
        ]);

        $product->update($validated);

        if (isset($validated['rawMaterials']) && is_array($validated['rawMaterials'])) {
            $rawMaterials = [];
            foreach ($validated['rawMaterials'] as $rawMaterial) {
                $rawMaterials[$rawMaterial['id']] =
                    [
                        'quantity' => $rawMaterial['quantity'],
                        'cost' => $rawMaterial['cost']
                    ];
            }
            $product->rawMaterials()->sync($rawMaterials);
        }

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->rawMaterials()->detach();
        $product->delete();

        return redirect()->route('products.index');
    }
}
