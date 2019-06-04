<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use DataTables;

class SaleController extends Controller
{
    public function getDatatables(Request $req)
    {
        $model = Sale::withCount('books');

        return DataTables::eloquent($model)->toJson();
    }

    public function getChart(Request $req)
    {
        $label = Sale::withCount('books')->pluck('name');
        $data = Sale::withCount('books')->pluck('books_count');

        $result = [
            'label' => $label,
            'data' => $data,
        ];

        return response()->json($result);
    }

    public function index()
    {
        return view('pages.sale.index');
    }

    public function store(Request $req)
    {
        Sale::create([
            'customer_name' => $req->customer_name,
            'books_id' => $req->books_id,
            'amount' => $req->amount,
            'cost' => $req->cost,
        ]);

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $req, $id)
    {
        $model = Sale::findOrFail($id);
        $model->update([
            'name' => $req->name,
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $model = Sale::findOrFail($id);
        $model->delete();
    
        return response()->json(['success' => true]);
    }
}