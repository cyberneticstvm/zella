<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\Exports\ProductExport;
use App\Exports\PurchaseExport;
use App\Exports\PurchaseReturnExport;
use App\Exports\SalesExport;
use App\Exports\SalesReturnExport;
use DB;

class ExcelController extends Controller
{
    public function productExport(Request $request){
        return Excel::download(new ProductExport(), 'product.xlsx');
    }

    public function purchaseExport(Request $request){
        return Excel::download(new purchaseExport($request), 'purchase.xlsx');
    }

    public function purchaseReturnExport(Request $request){
        return Excel::download(new purchaseReturnExport($request), 'purchase-return.xlsx');
    }

    public function salesExport(Request $request){
        return Excel::download(new salesExport($request), 'sales.xlsx');
    }

    public function salesReturnExport(Request $request){
        return Excel::download(new salesReturnExport($request), 'sales-return.xlsx');
    }
}
