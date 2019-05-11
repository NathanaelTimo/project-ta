<?php

namespace App\Imports;

use App\Models\Book;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class BooksImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    use Importable;

    public function model(array $row)
    {
        $category = $row['category'];
        $categories_id = Category::where('name', 'LIKE', "%$category%")->first();

        return new Book([
            'title' => $row['title'],
            'categories_id' => $categories_id->id,
            'qty' => $row['qty'],
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