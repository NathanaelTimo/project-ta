<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use DataTables;

class CategoryController extends Controller
{
    public function getData(Request $req)
    {
        $model = Category::query()->withCount('books');

        return DataTables::eloquent($model)->toJson();
    }

    public function index()
    {
        return view('pages.category.index');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
