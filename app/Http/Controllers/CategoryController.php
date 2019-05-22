<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use DataTables;

class CategoryController extends Controller
{
    public function getDatatables(Request $req)
    {
        $model = Category::query()->withCount('books');

        return DataTables::eloquent($model)->toJson();
    }

    public function index()
    {
        return view('pages.category.index');
    }

    public function store(Request $req)
    {
        Category::create([
            'name' => $req->name,
        ]);

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $req, $id)
    {
        $model = Category::findOrFail($id);
        $model->update([
            'name' => $req->name,
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $model = Category::findOrFail($id);
        $model->delete();
    
        return response()->json(['success' => true]);
    }
}