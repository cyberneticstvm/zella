<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class ProductExport implements FromQuery, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function __construct($id){
        $this->id = $id;
    }
    public function headings():array{
        return[
            'Product Name',
            'SKU',
            'Selling Price',
            'description',
        ];
    } 
    public function query()
    {
        return Product::query()->where('id', $this->id);
    }
}
