<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
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
        return Inertia::render('Home/NewOrder');
    }

    public function store()
    {
    }
}
