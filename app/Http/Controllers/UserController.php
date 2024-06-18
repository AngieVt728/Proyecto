<?php

namespace App\Http\Controllers;

use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
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
            'firstName' => 'required|string|max:50',
            'lastName' => 'required|string|max:50',
            'ci' => 'required|string|unique:users,ci|max:10|min:8',
            'contact' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:20',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'nullable|string|min:6',
            'avatar' => 'nullable|image|mimes:jpg,png|max:2048',
            'role' => 'required|integer|exists:roles,id',
        ]);

        $imageURL = !$validated['avatar']
            ? Cloudinary::upload($request->file('avatar')->getRealPath())->getSecurePath()
            : null;

        $validated['password'] = $validated['password'] ? Hash::make($validated['password']) : Hash::make($validated['ci']);
        $validated['contact'] = $validated['contact'] ?? 'Sin registro';
        $validated['address'] = $validated['address'] ?? 'Sin registro';
        $validated['username'] = $validated['username'] ?? User::generateUsername($validated['firstName'], $validated['lastName']);


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
        return Inertia::render('Users/Create', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): Response
    {
        return Inertia::render('Users/Create', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request::validate([
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
