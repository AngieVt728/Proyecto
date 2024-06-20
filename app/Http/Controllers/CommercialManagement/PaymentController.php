<?php

namespace App\Http\Controllers\CommercialManagement;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $filters = Request::all('search');
        $payments = Payment::select('*')
            ->orderBy('updated_at', 'desc')
            ->filter(Request::only('search'))
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($payment) => [
                'id' => $payment->id,
                'detail' => $payment->detail,
                'payment_date' => $payment->payment_date,
                'payment_balance' => $payment->payment_balance,
                'created_at' => $payment->created_at,
                'updated_at' => $payment->updated_at
            ]);

        return Inertia::render('Payments/Index', [
            'filters' => $filters,
            'payments' => $payments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $orders = Order::all();

        return Inertia::render('Payments/Create', [
            'orders' => $orders
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request::validate([
            'payment_date' => 'required|date|after_or_equal:today',
            'payment_balance' => 'required|numeric',
            'details' => 'nullable|max:300',
            'order_id' => 'required|integer|exists:orders,id',
        ]);

        Payment::create($validated);

        return redirect()->route('payments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $orders = Order::all();

        return Inertia::render('Payments/Show', [
            'payment' => $payment,
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return Inertia::render('Payments/Edit');
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
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payments.index');
    }
}
