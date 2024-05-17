<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Foundation\Application;
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
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    public function dashboard(): Response
    {
        $products = Product::select('id', 'name', 'stock')->get();
        $products = $this->generateColors($products);
        $rawMaterials = RawMaterial::select('id', 'name', 'stock')->get();
        $rawMaterials = $this->generateColors($rawMaterials);

        return Inertia::render('Dashboard', [
            'rawMaterials' => $rawMaterials,
            'products' => $products,
            'totalProducts' => Product::where('stock', '>=', 0)->count(),
            'totalOrders' => Order::whereDate('order_date', Carbon::now()->toDateString())->count(),
            'totalSales' => Sale::whereDate('created_at', Carbon::now()->toDateString())->count()
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
