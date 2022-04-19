<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\Exports\ProductExport;
use DB;

class ExcelController extends Controller
{
    public function productExport(Request $request){
        return Excel::download(new ProductExport(2), 'product.xlsx');
    }
}
