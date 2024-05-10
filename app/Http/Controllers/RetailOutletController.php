<?php

namespace App\Http\Controllers;

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
        $retail_outlets = RetailOutlet::all();

        return Inertia::render('RetailOutlets/Index', ['retail_outlets' => $retail_outlets]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('RetailOutlets/Create');
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
