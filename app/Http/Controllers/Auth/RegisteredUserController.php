<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'firstName' => 'required|string|max:50',
            'lastName' => 'required|string|max:50',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'contact' => 'nullable|regex:/^[0-9]+$/|min:5|max:20',
            'address' => 'nullable|string|min:5|max:150',
        ]);

        $username = User::generateUsername($request->firstName, $request->lastName);

        $user = User::create([
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'contact' => $request->contact,
            'address' => $request->address,
            'username' => $username,
            'ci' => null,
            'avatar' => null,
        ]);

        $user->assignRole('user');

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('user.home', absolute: false));
    }
}
