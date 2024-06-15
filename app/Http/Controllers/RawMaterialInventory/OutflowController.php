<?php

namespace App\Http\Controllers\RawMaterialInventory;

use App\Http\Controllers\Controller;
use App\Models\Outflow;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;

class OutflowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $filters = Request::all('search');
        $outflows = Outflow::select('*')
            ->orderBy('updated_at', 'desc')
            ->filter(Request::only('search'))
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($entry) => [
                'id' => $entry->id,
                'outflow_date' => $entry->outflow_date,
                'quantity' => $entry->quantity,
                'created_at' => $entry->created_at,
                'updated_at' => $entry->updated_at
            ]);

        return Inertia::render('Outflows/Index', [
            'filters' => $filters,
            'outflows' => $outflows
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
