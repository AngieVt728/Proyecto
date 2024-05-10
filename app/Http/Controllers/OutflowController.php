<?php

namespace App\Http\Controllers;

use App\Models\Outflow;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OutflowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $outflows = Outflow::all();

        return Inertia::render('Outflows/Index', ['outflows' => $outflows]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Outflows/Create');
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
    public function show(Outflow $outflow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Outflow $outflow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Outflow $outflow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Outflow $outflow)
    {
        //
    }
}
