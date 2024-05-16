<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\RetailOutlet;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RetailOutletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('RetailOutlets/Index', [
            'retailOutlets' => RetailOutlet::with('customer:id,first_name,last_name')
                ->orderBy('updated_at', 'desc')
                ->get()
                ->map(function ($outlet) {
                    $outlet->owner_name = $outlet->customer->first_name . ' ' . $outlet->customer->last_name;
                    unset($outlet->customer);
                    return $outlet;
                })
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('RetailOutlets/Create', [
            'customers' => Customer::selectRaw("id, CONCAT(first_name, ' ', last_name) as full_name")
                ->orderBy('first_name', 'asc')
                ->get()
        ]);
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
    public function show(RetailOutlet $retailOutlet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RetailOutlet $retailOutlet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RetailOutlet $retailOutlet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RetailOutlet $retailOutlet)
    {
        //
    }
}
