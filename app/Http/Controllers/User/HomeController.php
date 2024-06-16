<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function home(): Response
    {
        $products = Product::orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return Inertia::render('Home/Home', [
            'products' => $products
        ]);
    }

    public function products(): Response
    {
        $products = Product::all();

        return Inertia::render('Home/Product', [
            'products' => $products
        ]);
    }

    public function orders(): Response
    {
        $auth = auth()->user();
        $orders = $auth->orders();

        return Inertia::render('Home/Order', [
            'orders' => $orders
        ]);
    }

    public function create(): Response
    {
        $products = Product::all();

        return Inertia::render('Home/NewOrder', [
            'products' => $products
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'detail' => 'required|string|max:300',
            'order_date' => 'required|date',
            'deliver_date' => 'required|date|after_or_equal:order_date',
        ]);

        // Agregar el user_id del usuario autenticado
        $validated['user_id'] = Auth::id();

        // Crear la orden
        Order::create($validated);

        return redirect()->route('user.home');
    }
}
