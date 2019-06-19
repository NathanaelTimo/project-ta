<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Sale;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function getChart(Request $req)
    {
        $label = Sale::with(['item'])
            ->select('items_id')
            // ->whereMonth('date_invoice', 1)
            ->groupBy('items_id')
            ->orderBy('items_id')
            ->get()
            ->pluck('item.name');

        $data = Sale::orderBy('items_id')
            // ->whereMonth('date_invoice', 1)
            ->get()
            ->groupBy('items_id')
            ->map(function($row) {
                return $row->sum('qty');
            })
            ->values();

        $result = [
            'label' => $label,
            'data' => $data,
        ];

        return response()->json($result);
    }

    public function getTopItem(Request $req)
    {
        $model = Item::selectRaw('items.name, IFNULL(SUM(qty), 0) as qty')
            ->orderBy('qty', 'DESC')
            ->leftJoin('sales', 'items.id', '=', 'sales.items_id')
            ->groupBy(['items.name'])
            ->get()
            ->take(3);

        return response()->json($model); 
    }

    public function getTopCustomer(Request $req)
    {
        $model = Sale::selectRaw('customer_name, IFNULL(SUM(qty), 0) as qty')
            ->orderBy('qty', 'DESC')
            ->groupBy(['customer_name'])
            ->get()
            ->take(3);

        return response()->json($model); 
    }
}
