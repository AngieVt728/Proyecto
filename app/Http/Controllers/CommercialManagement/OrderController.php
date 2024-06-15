<?php

namespace App\Http\Controllers\CommercialManagement;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $filters = Request::all('search');
        $orders = Order::select('*')
            ->orderBy('updated_at', 'desc')
            ->filter(Request::only('search'))
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($order) => [
                'id' => $order->id,
                'detail' => $order->detail,
                'order_date' => $order->order_date,
                'deliver_date' => $order->deliver_date,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at
            ]);

        return Inertia::render('Orders/Index', [
            'filters' => $filters,
            'orders' => $orders
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
