<?php

namespace App\Imports;

use App\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows){
        foreach ($rows as $row) {
           Product::create([
            'barcode'=>$row['barcode'],
            'name'=>$row['name'],
            'description'=>$row['description'],
            'purchase_price'=>$row['purchase_price'],
            'retail_price'=>$row['retail_price'],
            'expiration'=>$row['expiration'],
            'quantity'=>$row['quantity'],
           ]);
        }
    }
}
