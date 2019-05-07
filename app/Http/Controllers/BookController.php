<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Imports\BooksImport;
use Illuminate\Http\Request;
use DB;

class BookController extends Controller
{
    public function index()
    {
        //
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

    public function update(Request $request, Book $book)
    {
        //
    }

    public function destroy(Book $book)
    {
        //
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
