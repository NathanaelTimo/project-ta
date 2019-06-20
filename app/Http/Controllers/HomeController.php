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
        if($req->month != 'all') {
            $req->month = $req->month+1;
        }

        $label = $this->chartLabel($req->month);
        $data = $this->chartData($req->month);

        $result = [
            'label' => $label,
            'data' => $data,
        ];

        return response()->json($result);
    }

    public function getTopItem(Request $req)
    {
        $model = Item::selectRaw('items.name, IFNULL(SUM(qty), 0) as qty');

        if($req->month != 'all') {
            $req->month = $req->month+1;
            $model->whereMonth('date_invoice', $req->month);
        }

        $model = $model->orderBy('qty', 'DESC')
            ->leftJoin('sales', 'items.id', '=', 'sales.items_id')
            ->groupBy(['items.name'])
            ->get()
            ->take(3);

        return response()->json($model); 
    }

    public function getTopCustomer(Request $req)
    {
        $model = Sale::selectRaw('customer_name, IFNULL(SUM(qty), 0) as qty');

        if($req->month != 'all') {
            $req->month = $req->month+1;
            $model->whereMonth('date_invoice', $req->month);
        }

        $model = $model->orderBy('qty', 'DESC')
            ->groupBy(['customer_name'])
            ->get()
            ->take(3);

        return response()->json($model); 
    }

    protected function chartLabel($month)
    {
        $model = Sale::with(['item'])
            ->select('items_id')
            ->orderBy('items_id');

        if($month != 'all') {
            $model->whereMonth('date_invoice', $month);
        }

        $model = $model->groupBy('items_id')
            ->get()
            ->pluck('item.name');

        return $model;
    }

    protected function chartData($month)
    {
        $model = Sale::orderBy('items_id');

        if($month != 'all') {
            $model->whereMonth('date_invoice', $month);
        }

        $model = $model->get()
            ->groupBy('items_id')
            ->map(function($row) {
                return $row->sum('qty');
            })
            ->values();

        return $model;
    }
}
