<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\Exports\ProductExport;
use App\Exports\PurchaseExport;
use DB;

class ExcelController extends Controller
{
    public function productExport(Request $request){
        return Excel::download(new ProductExport(), 'product.xlsx');
    }

    public function purchaseExport(Request $request){
        return Excel::download(new purchaseExport($request), 'purchase.xlsx');
    }
}
