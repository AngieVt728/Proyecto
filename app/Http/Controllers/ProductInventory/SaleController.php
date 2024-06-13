<?php

namespace App\Http\Controllers\ProductInventory;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $filters = Request::all('search');
        $sales = Sale::select('*')
            ->orderBy('updated_at', 'desc')
            ->filter(Request::only('search'))
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($sale) => [
                'id' => $sale->id,
                'quantity' => $sale->quantity,
                'total_price' => $sale->total_price,
                'description' => $sale->description,
                'created_at' => $sale->created_at,
                'updated_at' => $sale->updated_at
            ]);

        return Inertia::render('Sales/Index', [
            'filters' => $filters,
            'sales' => $sales
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Sales/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
