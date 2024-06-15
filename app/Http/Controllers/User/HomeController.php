<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function home(): Response
    {
        return Inertia::render('Home/Home');
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
        return Inertia::render('Home/Order');
    }
}
