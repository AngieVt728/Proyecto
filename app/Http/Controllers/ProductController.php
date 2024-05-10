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
        $products = Product::all();

        return Inertia::render('Products/Index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $raw_materials = RawMaterial::all()->sortBy('name');

        return Inertia::render('Products/Create', ['raw_materials' => $raw_materials]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validar los datos de entrada
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:300',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'rawMaterials' => 'required|array',
            'rawMaterials.*' => 'exists:raw_materials,id'
        ]);

        // Crear un nuevo producto
        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock']
        ]);

        // Asignar materias primas al producto si están definidas
        if (isset($validated['rawMaterials'])) {
            $product->raw_materials()->attach($validated['rawMaterials']);
        }

        // Redirigir al índice de productos
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
        $raw_materials_product = $product->raw_materials()->get();

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
