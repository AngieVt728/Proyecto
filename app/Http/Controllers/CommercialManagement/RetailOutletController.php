<?php

namespace App\Http\Controllers\CommercialManagement;

use App\Http\Controllers\Controller;
use App\Models\RetailOutlet;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
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
        $retailOutlets = RetailOutlet::with('user:id,first_name,last_name')
            ->orderBy('updated_at', 'desc')
            ->filter(Request::only('search'))
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($outlet) => [
                'id' => $outlet->id,
                'name' => $outlet->name,
                'nit' => $outlet->nit,
                'owner_name' => $outlet->user->first_name . ' ' . $outlet->user->last_name,
                'address' => $outlet->address,
                'description' => $outlet->description,
                'image_url' => $outlet->image_url,
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
        $customers = User::selectRaw("id, CONCAT(first_name, ' ', last_name) as full_name")
            ->whereHas('roles', function ($query) {
                $query->where('name', 'user');
            })
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
        $validated = $request::validate(([
            'name' => 'required|string|max:50',
            'nit' => 'required|string|max:20|regex:/^[0-9]+$/|unique:retail_outlets,nit',
            'description' => 'nullable|string|max:300',
            'address' => 'required|string|max:255',
            'lat' => 'required|numeric|max:255',
            'lng' => 'required|numeric|max:255',
            'image' => 'nullable|image|mimes:jpg,png|max:2048',
            'user_id' => 'required|integer|exists:users,id'
        ]));

        $imageURL = null;
        if ($request::hasFile('image')) {
            $imagePath = $request::file('image');
            $imageSaveName = $validated['nit'] . '.' . $request::file('image')->getClientOriginalExtension();
            $imageURL = $request::hasFile('image')
                ? url(Storage::url($imagePath->storeAs('retail_outlets', $imageSaveName, 'public')))
                : null;
        }

        $retailOutlet = [
            ...$validated,
            'image_url' => $imageURL
        ];

        RetailOutlet::create($retailOutlet);

        return redirect()->route('retail-outlets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(RetailOutlet $retailOutlet): Response
    {
        $customers = User::selectRaw("id, CONCAT(first_name, ' ', last_name) as full_name")
            ->whereHas('roles', function ($query) {
                $query->where('name', 'user');
            })
            ->orderBy('first_name', 'asc')
            ->get();

        return Inertia::render('RetailOutlets/Show', [
            'retailOutlet' => $retailOutlet,
            'customers' => $customers,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RetailOutlet $retailOutlet)
    {
        $customers = User::selectRaw("id, CONCAT(first_name, ' ', last_name) as full_name")
            ->whereHas('roles', function ($query) {
                $query->where('name', 'user');
            })
            ->orderBy('first_name', 'asc')
            ->get();

        return Inertia::render('RetailOutlets/Edit', [
            'retailOutlet' => $retailOutlet,
            'customers' => $customers,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RetailOutlet $retailOutlet): RedirectResponse
    {
        $validated = $request::validate(([
            'name' => 'required|string|max:50',
            'nit' => [
                'required',
                'string',
                'max:20',
                'regex:/^[0-9]+$/',
                Rule::unique('retail_outlets')->ignore($retailOutlet->id),
            ],
            'description' => 'nullable|string|max:300',
            'address' => 'required|string|max:255',
            'lat' => 'required|numeric|max:255',
            'lng' => 'required|numeric|max:255',
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
