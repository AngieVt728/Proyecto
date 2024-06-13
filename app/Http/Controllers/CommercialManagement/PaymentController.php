<?php

namespace App\Http\Controllers\CommercialManagement;

use App\Http\Controllers\Controller;
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
    public function create(): Response
    {
        return Inertia::render('Payments/Create');
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
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
