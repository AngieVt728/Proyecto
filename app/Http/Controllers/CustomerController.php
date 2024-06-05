<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $filters = Request::all('search');
        $customers = Customer::select('*')
            ->orderBy('updated_at', 'desc')
            ->filter(Request::only('search'))
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($customer) => [
                'id' => $customer->id,
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'ci' => $customer->ci,
                'email' => $customer->email,
                'email_verified_at' => $customer->email_verified_at,
                'phone_number' => $customer->phone_number,
                'address' => $customer->address,
                'created_at' => $customer->created_at,
                'updated_at' => $customer->updated_at
            ]);

        return Inertia::render('Customers/Index', [
            'filters' => $filters,
            'customers' => $customers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Customers/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $validated = $request::validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'ci' => 'required|string|unique:users,ci|max:10|min:8',
            'email' => 'required|email|max:100|unique:users,email',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);
        $validated['password'] = Hash::make($validated['ci']);
        $validated['phone_number'] = $validated['phone_number'] ?? 'No registrado';
        $validated['address'] = $validated['address'] ?? 'No registrado';

        Customer::create($validated);

        return redirect()->route('customers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer): Response
    {
        return Inertia::render('Customers/Create', [
            'customer' => $customer->makeHidden('password')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer): Response
    {
        return Inertia::render('Customers/Create', [
            'customer' => $customer->makeHidden('password')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request::validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'ci' => 'required|string|max:10|min:8|unique:users,ci,' . $customer['id'],
            'email' => 'required|email|max:100|unique:users,email,' . $customer['id'],
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);
        $customer->update($validated);

        return redirect()->route('customers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer): RedirectResponse
    {
        $customer->delete();

        return redirect()->route('customers.index');
    }
}
