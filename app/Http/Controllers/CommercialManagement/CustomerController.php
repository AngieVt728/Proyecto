<?php

namespace App\Http\Controllers\CommercialManagement;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
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
        $customers = User::where('id', '!=', auth()->id())
            ->whereHas('roles', function ($query) {
                $query->where('name', 'user');
            })
            ->with('roles')
            ->orderBy('updated_at', 'desc')
            ->filter(Request::only('search'))
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($user) => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'ci' => $user->ci,
                'username' => $user->username,
                'email' => $user->email,
                'contact' => $user->contact,
                'role' =>  $user->roles->first()->name ?? '',
                'address' => $user->address,
                'image_url' => $user->image_url,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
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
            'firstName' => 'required|string|max:50|regex:/^[a-zA-Z]+$/',
            'lastName' => 'required|string|max:50|regex:/^[a-zA-Z]+$/',
            'ci' => 'required|string|unique:users,ci|max:10|min:4|regex:/^[0-9]+$/',
            'contact' => 'nullable|string|max:20|regex:/^[0-9]+$/',
            'address' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:20|regex:/^[a-z0-9]+$/',
            'email' => 'required|email|max:100|unique:users,email',
            'avatar' => 'nullable|image|mimes:jpg,png|max:2048',
            'password' => 'nullable|string|min:6',
        ]);

        $validated['password'] = $validated['password'] ? Hash::make($validated['password']) : Hash::make($validated['ci']);
        $validated['username'] = $validated['username'] ?? User::generateUsername($validated['firstName'], $validated['lastName']);

        $imageURL = null;
        if ($request::hasFile('avatar')) {
            $imagePath = $request::file('avatar');
            $imageSaveName = $validated['username'] . '.' . $request::file('avatar')->getClientOriginalExtension();
            $imageURL = $request::hasFile('avatar')
                ? url(Storage::url($imagePath->storeAs('customers', $imageSaveName, 'public')))
                : null;
        }

        $user = User::create([
            'first_name' => $validated['firstName'],
            'last_name' => $validated['lastName'],
            'ci' => $validated['ci'],
            'contact' => $validated['contact'],
            'address' => $validated['address'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'image_url' => $imageURL,
        ]);

        $user->assignRole('user');

        return redirect()->route('customers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $customer): Response
    {
        return Inertia::render('Customers/Show', [
            'user' => $customer
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $customer): Response
    {
        return Inertia::render('Customers/Edit', [
            'user' => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $customer): RedirectResponse
    {
        $validated = $request::validate([
            'firstName' => 'required|string|max:50|regex:/^[a-zA-Z]+$/',
            'lastName' => 'required|string|max:50|regex:/^[a-zA-Z]+$/',
            'ci' => [
                'required',
                'string',
                'max:10',
                'min:4',
                'regex:/^[0-9]+$/',
                Rule::unique('users')->ignore($customer->id),
            ],
            'contact' => 'nullable|string|max:20|regex:/^[0-9]+$/',
            'address' => 'nullable|string|max:255',
            'username' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[a-z0-9]+$/',
                Rule::unique('users')->ignore($customer->id),
            ],
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('users')->ignore($customer->id),
            ],
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $customer): RedirectResponse
    {
        $customer->delete();

        return redirect()->route('customers.index');
    }
}
