<?php

namespace App\Imports;

use App\Models\Item;
use App\Models\Sale;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class SalesImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    use Importable;

    public function model(array $row)
    {
        $item = $row['item'];
        $items = Item::firstOrCreate(['name' => $item]);
        $items_id = $items ? $items->id : null;

        return new Sale([
            'no_invoice' => $row['invoice_no'],
            'date_invoice' => getFormatDate($row['invoice_date']),
            'customer_name' => $row['customer_name'],
            'description' => $row['description'],
            'items_id' => $items_id,
            'qty' => $row['qty'],
            'total' => $row['total'],
        ]);
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }
}