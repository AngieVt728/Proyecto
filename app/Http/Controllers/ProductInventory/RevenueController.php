<?php

namespace App\Http\Controllers\ProductInventory;

use App\Http\Controllers\Controller;
use App\Models\Revenue;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;

class RevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $filters = Request::all('search');
        $revenues = Revenue::select('*')
            ->orderBy('updated_at', 'desc')
            ->filter(Request::only('search'))
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($revenue) => [
                'id' => $revenue->id,
                'revenue_date' => $revenue->revenue_date,
                'quantity' => $revenue->quantity,
                'description' => $revenue->description,
                'created_at' => $revenue->created_at,
                'updated_at' => $revenue->updated_at
            ]);

        return Inertia::render('Revenues/Index', [
            'filters' => $filters,
            'revenues' => $revenues
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Revenues/Create');
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
    public function show(Revenue $revenue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Revenue $revenue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Revenue $revenue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Revenue $revenue)
    {
        //
    }
}
