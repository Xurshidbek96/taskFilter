<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function statistic_month(){

        $statistics = Order::selectRaw('SUM(summa) as total_sum, DATE_FORMAT(created_at, "%M") as month, DATE_FORMAT(created_at, "%Y") as year' )
        ->groupBy('month', 'year')
        ->get();

        return response()->json($statistics);

    }

    public function chartByMonth()
    {
        $data = Product::with('orders')
            ->whereHas('orders', function ($query) {
                $query->whereMonth('created_at', '=', now()->month);
            })
            ->get();

        $chartData = $data->map(function ($product) {
            return [
                'name' => $product->name,
                'amount' => $product->orders->sum('amount'),
                'summa' => $product->orders->sum('summa')
            ];
        });

        return response()->json($chartData);
    }

    public function chartByTwoMonths()
    {
        $data = Order::selectRaw('SUM(summa) as total_sum, DATE_FORMAT(created_at, "%M") as month')
            ->whereIn('month', [now()->month, now()->subMonth()->month])
            ->groupBy('month')
            ->get();

        $chartData = $data->map(function ($order) {
            return [
                'month' => $order->month,
                'total_sum' => $order->total_sum,
            ];
        });

        return response()->json($chartData);
    }
}
