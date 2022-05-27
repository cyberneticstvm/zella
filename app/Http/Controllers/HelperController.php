<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HelperController extends Controller
{
    public function getproducts(){
        $products = DB::table('products')->selectRaw("id, CONCAT_WS(' - ', name, sku) AS name")->get();
        return response()->json($products);
    }

    public function getproduct($id){
        $product = DB::table('products')->find($id);
        return response()->json($product);
    }

    public function checkStockInHand($id, $qty, $dval){
        if($dval == 1 || $dval == 0):
            $stockin = DB::table('purchase_details')->where('product', $id)->where('is_return', 0)->sum('qty');
            $stockout = DB::table('sales_details')->where('product', $id)->where('is_return', 0)->sum('qty');
            $stock = $stockin - $stockout;
            $item = ($stock >= $qty) ? true : false;
            return $item;
        else:
            return true; // if dval = 1 or dval = 0 then it will be sales / deadstock transaction. Otherwise it will be purchase transaction and need not be perform this validaton.
        endif;
    }
}
