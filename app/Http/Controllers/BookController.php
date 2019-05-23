<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Imports\BooksImport;
use DataTables;
use DB;

class BookController extends Controller
{
    public function getData(Request $req)
    {
        $model = Book::with(['categories']);

        return DataTables::eloquent($model)->toJson();
    }

    public function getChart(Request $req)
    {
        $label = Book::pluck('title');
        $data = Book::pluck('qty');

        $result = [
            'label' => $label,
            'data' => $data,
        ];

        return response()->json($result);
    }

    public function index()
    {
        return view('pages.book.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Book $book)
    {
        //
    }

    public function edit(Book $book)
    {
        //
    }

    public function update(Request $req, $id)
    {
        $model = Book::findOrFail($id);
        $model->update([
            'title' => $req->title,
            'categories_id' => $req->categories['id'],
            'qty' => $req->qty,
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $model = Book::findOrFail($id);
        $model->delete();
    
        return response()->json(['success' => true]);
    }

    public function import(Request $req)
    {
        if($req->file) {
            DB::beginTransaction();
            $data = new BooksImport();
            try {
                $data->import($req->file);
                DB::commit();
                return response()->json(['success' => true]);
            } catch(\Illuminate\Database\QueryException $ex) {
                DB::rollback();
                return response()->json([
                    'message' => 'Terjadi kesalahan pada database',
                    'console' => $ex->getMessage(),
                ]);
            }
        }
        else {
            return back();
        }
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
        $file = 'template_import';
        return response()->download(storage_path('app/template/'.$file.'.xlsx'),$file.'.xlsx',$headers);
    }
}
