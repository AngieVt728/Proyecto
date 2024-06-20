<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
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
        $bags = Auth::user()->bags()->get();

        return Inertia::render('Home/Product', [
            'products' => $products,
            'bags' => $bags,
        ]);
    }

    public function orders(): Response
    {
        $orders = Auth::user()->orders()
            ->with('orderProducts')
            ->orderBy('deliver_date', 'asc')
            ->get();

        // $products = [];
        // foreach ($orders['order_products'] as $order) {
        //     $products[] = $order;
        // }

        return Inertia::render('Home/Order', [
            'orders' => $orders,
            // 'products' => $products
        ]);
    }

    public function order(): Response
    {
        $bags = Auth::user()->bags()->get();
        $productIdsInBags = $bags->pluck('product_id');

        $productsInBags = Product::whereIn('id', $productIdsInBags)->get();

        return Inertia::render('Home/NewOrder', [
            'products' => $productsInBags,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'deliver_date' => 'required|date|after_or_equal:today',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'deliver_date' => $validated['deliver_date'],
            'status' => 'Por aceptar',
            'user_id' => Auth::id(),
        ]);

        foreach ($validated['products'] as $product) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
            ]);
        }

        Auth::user()->bags()->delete();

        return redirect()->route('user.orders');
    }
}
