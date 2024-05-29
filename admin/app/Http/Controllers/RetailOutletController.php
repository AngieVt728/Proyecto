<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\RetailOutlet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;

class RetailOutletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $filters = Request::all('search');
        $retailOutlets = RetailOutlet::with('customer:id,first_name,last_name')
            ->orderBy('updated_at', 'desc')
            ->filter(Request::only('search'))
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($outlet) => [
                'id' => $outlet->id,
                'name' => $outlet->name,
                'nit' => $outlet->nit,
                'owner_name' => $outlet->customer->first_name . ' ' . $outlet->customer->last_name,
                'address' => $outlet->address,
                'description' => $outlet->description,
                'created_at' => $outlet->created_at,
                'updated_at' => $outlet->updated_at
            ]);

        return Inertia::render('RetailOutlets/Index', [
            'filters' => $filters,
            'retailOutlets' => $retailOutlets
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $customers = Customer::selectRaw("id, CONCAT(first_name, ' ', last_name) as full_name")
            ->orderBy('first_name', 'asc')
            ->get();

        return Inertia::render('RetailOutlets/Create', [
            'customers' => $customers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(([
            'name' => 'required|string|max:50',
            'nit' => 'required|string|max:20',
            'description' => 'nullable|string|max:300',
            'address' => 'required|string|max:255',
            'lat' => 'required|numeric|max:255',
            'lng' => 'required|numeric|max:255',
            'customer_id' => 'required|integer|exists:customers,id'
        ]));

        $validated['description'] = $validated['description'] ?? 'Sin descripción';

        RetailOutlet::create($validated);

        return redirect()->route('retail-outlets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(RetailOutlet $retailOutlet): Response
    {
        $customers = Customer::selectRaw("id, CONCAT(first_name, ' ', last_name) as full_name")
            ->orderBy('first_name', 'asc')
            ->get();

        return Inertia::render('RetailOutlets/Create', [
            'customers' => $customers,
            'retailOutlet' => $retailOutlet
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RetailOutlet $retailOutlet)
    {
        $customers = Customer::selectRaw("id, CONCAT(first_name, ' ', last_name) as full_name")
            ->orderBy('first_name', 'asc')
            ->get();

        return Inertia::render('RetailOutlets/Create', [
            'customers' => $customers,
            'retailOutlet' => $retailOutlet
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RetailOutlet $retailOutlet): RedirectResponse
    {
        $validated = $request->validate(([
            'name' => 'required|string|max:50',
            'nit' => 'required|string|max:20',
            'description' => 'nullable|string|max:300',
            'address' => 'required|string|max:255',
            'lat' => 'required|numeric|max:255',
            'lng' => 'required|numeric|max:255',
            'customer_id' => 'required|integer|exists:customers,id'
        ]));
        $retailOutlet->update($validated);

        return redirect()->route('retail-outlets.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RetailOutlet $retailOutlet): RedirectResponse
    {
        $retailOutlet->delete();

        return redirect()->route('retail-outlets.index');
    }
}
