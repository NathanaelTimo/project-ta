<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Imports\SalesImport;
use DataTables;
use DB;

class SaleController extends Controller
{
    public function getData(Request $req)
    {
        $model = Sale::with(['item'])->select('sales.*');

        return DataTables::eloquent($model)->toJson();
    }

    public function index()
    {
        return view('pages.sale.index');
    }

    public function store(Request $req)
    {

    }

    public function show($id)
    {

    }

    public function update(Request $req, $id)
    {

    }

    public function destroy($id)
    {

    }

    public function import(Request $req)
    {
        $filename = $_FILES['file']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if($req->file) {
            DB::beginTransaction();
            $data = new SalesImport();
            try {
                switch($ext) {
                    case 'xlsx':
                        $data->import($req->file, null, \Maatwebsite\Excel\Excel::XLSX);
                        break;
                }                
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

    public function downloadTemplateXlsx()
    {
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
        $file = 'template_import_xlsx';
        $ext = '.xlsx';
        return response()->download(storage_path('app/template/'.$file.$ext), $file.$ext, $headers);
    }
}