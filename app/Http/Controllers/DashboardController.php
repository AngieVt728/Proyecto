<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\RetailOutlet;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

    public function dashboard(): Response
    {
        $rawMaterials = $this->generateColors(RawMaterial::select('id', 'name', 'stock')->get());
        $products = $this->generateColors(Product::select('id', 'name', 'stock')->get());
        $totalProducts = Product::where('stock', '>=', 0)->count();
        $totalOrders = Order::whereDate('created_at', Carbon::now()->toDateString())->count();
        $totalSales = Sale::whereDate('created_at', Carbon::now()->toDateString())->count();
        $retailOutlets = RetailOutlet::select('id', 'name', 'lat', 'lng')
            ->orderBy('name', 'asc')
            ->get()
            ->map(function ($outlet) {
                return [
                    'id' => $outlet->id,
                    'name' => $outlet->name,
                    'position' => [
                        'lat' => (float) $outlet->lat,
                        'lng' => (float) $outlet->lng
                    ]
                ];
            });

        return Inertia::render('Dashboard', [
            'rawMaterials' => $rawMaterials,
            'products' => $products,
            'totalProducts' => $totalProducts,
            'totalOrders' => $totalOrders,
            'totalSales' => $totalSales,
            'retailOutlets' => $retailOutlets
        ]);
    }

    private function generateColors($collection)
    {
        $usedColors = [];

        foreach ($collection as $item) {
            $color = fake()->hexColor();

            while (in_array($color, $usedColors)) {
                $color = fake()->hexColor();
            }

            $usedColors[] = $color;
            $item->color = $color;
        }

        return $collection;
    }
}
