<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
  
    public function headings():array{
        return[
            'Product Name',
            'Collection Name',
            'SKU',
            'Selling Price',
            'description',
        ];
    } 
    public function collection()
    {
        //return Product::query()->where('id', 1);
        $products = Product::leftJoin('collections', 'products.collection', '=', 'collections.id')->select('products.name as pname', 'collections.name as cname', 'products.sku', 'products.selling_price', 'products.description')->get();
        return $products;
    }
}
