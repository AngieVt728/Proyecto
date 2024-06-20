<?php

namespace App\Http\Controllers\CommercialManagement;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
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
                'deliver_date' => $order->deliver_date,
                'status' => $order->status,
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
    public function create(): Response
    {
        return Inertia::render('Orders/Create');
    }

    public function store(Request $request)
    {
        // Implementar la lógica para almacenar el recurso aquí
    }

    public function show(Order $order): Response
    {
        $orderProducts = $order->products()->withPivot('quantity')->get();
        $totalPrice = number_format($orderProducts->sum(function ($product) {
            return $product->price * $product->pivot->quantity;
        }), 2);
        $mappedProducts = $orderProducts->map(function ($product) {
            return [
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'quantity' => $product->pivot->quantity,
            ];
        });

        return Inertia::render('Orders/Show', [
            'order' => $order,
            'orderProducts' => $orderProducts,
            'products' => $mappedProducts,
            'totalPrice' => $totalPrice,
        ]);
    }

    public function edit(Order $order): Response
    {
        return Inertia::render('Orders/Edit', [
            'order' => $order,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request::validate([
            'deliver_date' => 'required|date|after_or_equal:today',
            'status' => 'required|numeric'
        ]);

        $statusEnum = [
            1 => 'Por aceptar',
            2 => 'En proceso',
            3 => 'Entregado',
        ];
        $validated['status'] = $statusEnum[$validated['status']];

        $order->update($validated);
        return redirect()->route('orders.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index');
    }
}
