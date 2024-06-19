<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
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
        $filters = Request::all('search');
        $users = User::where('id', '!=', auth()->id())
            ->whereDoesntHave('roles', function ($query) {
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
                'email_verified_at' => $user->email_verified_at,
                'contact' => $user->contact,
                'role' =>  $user->roles->first()->name ?? '',
                'address' => $user->address,
                'image_url' => $user->image_url,
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
        $roles = Role::where('name', '!=', 'user')->get();
        $permissions = Permission::all();

        return Inertia::render('Users/Create', [
            'roles' => $roles,
            'permissions' => $permissions
        ]);
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
            'password' => 'nullable|string|min:6',
            'avatar' => 'nullable|image|mimes:jpg,png|max:2048',
            'role' => 'required|integer|exists:roles,id',
        ]);

        $validated['password'] = $validated['password'] ? Hash::make($validated['password']) : Hash::make($validated['ci']);
        $validated['username'] = $validated['username'] ?? User::generateUsername($validated['firstName'], $validated['lastName']);

        $imagePath = $request::file('avatar');
        $imageSaveName = $validated['username'] . '.' . $request::file('avatar')->getClientOriginalExtension();
        $imageURL = $request::hasFile('avatar')
            ? url(Storage::url($imagePath->storeAs('users', $imageSaveName, 'public')))
            : null;

        $roles = [
            1 => 'super-admin',
            2 => 'admin',
            3 => 'manager',
        ];

        $validated['role'] = $roles[$validated['role']];

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

        $user->assignRole($validated['role']);

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): Response
    {
        return Inertia::render('Users/Show', [
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'ci' => $user->ci,
                'username' => $user->username,
                'email' => $user->email,
                'contact' => $user->contact,
                'role' => $user->roles->first()->name ?? '',
                'address' => $user->address,
                'image_url' => $user->image_url,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): Response
    {
        $roles = Role::where('name', '!=', 'user')->get();
        $permissions = Permission::all();

        return Inertia::render('Users/Edit', [
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'ci' => $user->ci,
                'username' => $user->username,
                'email' => $user->email,
                'contact' => $user->contact,
                'role' => $user->roles->first()->id ?? '',
                'address' => $user->address,
                'image_url' => $user->image_url,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ],
            'roles' => $roles,
            'permissions' => $permissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
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
                Rule::unique('users')->ignore($user->id),
            ],
            'contact' => 'nullable|string|max:20|regex:/^[0-9]+$/',
            'address' => 'nullable|string|max:255',
            'username' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[a-z0-9]+$/',
                Rule::unique('users')->ignore($user->id),
            ],
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('users')->ignore($user->id),
            ],
            'avatar' => 'nullable|image|mimes:jpg,png|max:2048',
            'role' => 'required|integer|exists:roles,id',
        ]);

        if ($request::hasFile('avatar')) {
            $imagePath = $request::file('avatar');
            $imageSaveName = $validated['username'] . '.' . $imagePath->getClientOriginalExtension();
            $imageStoredPath = $imagePath->storeAs('users', $imageSaveName, 'public');
            $validated['avatar'] = Storage::url($imageStoredPath);
        } else {
            unset($validated['avatar']);
        }

        $roles = [
            1 => 'super-admin',
            2 => 'admin',
            3 => 'manager',
        ];

        $validated['role'] = $roles[$validated['role']];

        $user->update($validated);

        $user->syncRoles([$validated['role']]);

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
