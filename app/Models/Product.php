<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'collection',
        'sku',
        'size',
        'color',
        'material',
        'selling_price',
        'description',
        'vat_applicable',
        'allow_sales_zero_qty',
    ];
}
