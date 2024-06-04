<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $filters = Request::all('search', 'role');
        $users = User::where('id', '!=', auth()->id())
            ->with('roles')
            ->orderBy('updated_at', 'desc')
            ->filter(Request::only('search', 'role'))
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($user) => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'ci' => $user->ci,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'phone_number' => $user->phone_number,
                'role' =>  $user->roles->first()->name,
                'address' => $user->address,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ]);

        return Inertia::render('Users/Index', [
            'filters' => $filters,
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Users/Create', [
            'roles' => Role::all(),
            'permissions' => Permission::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
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

        User::create($validated);

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): Response
    {
        return Inertia::render('Users/Create', [
            'user' => $user->makeHidden('password')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): Response
    {
        return Inertia::render('Users/Create', [
            'user' => $user->makeHidden('password')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'ci' => 'required|string|max:10|min:8|unique:users,ci,' . $user['id'],
            'email' => 'required|email|max:100|unique:users,email,' . $user['id'],
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);
        $user->update($validated);

        return redirect()->route('users.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('users.index');
    }
}
