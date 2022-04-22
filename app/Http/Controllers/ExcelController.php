<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\Exports\ProductExport;
use App\Exports\PurchaseExport;
use App\Exports\PurchaseReturnExport;
use App\Exports\SalesExport;
use App\Exports\SalesReturnExport;
use App\Exports\ExpenseExport;
use DB;

class ExcelController extends Controller
{
    public function productExport(Request $request){
        return Excel::download(new ProductExport(), 'product.xlsx');
    }

    public function purchaseExport(Request $request){
        return Excel::download(new PurchaseExport($request), 'purchase.xlsx');
    }

    public function purchaseReturnExport(Request $request){
        return Excel::download(new PurchaseReturnExport($request), 'purchase-return.xlsx');
    }

    public function salesExport(Request $request){
        return Excel::download(new SalesExport($request), 'sales.xlsx');
    }

    public function salesReturnExport(Request $request){
        return Excel::download(new SalesReturnExport($request), 'sales-return.xlsx');
    }

    public function expenseExport(Request $request){
        return Excel::download(new ExpenseExport($request), 'expense.xlsx');
    }
}
