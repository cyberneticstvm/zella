<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Str;

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

    public function updateSKU(){
        $products = DB::table('products')->get();
        foreach($products as $key => $value):
            $upd = DB::table('products')->where('id', $value->id)->update(['sku' => Str::random(10)]);
        endforeach;
    }

    public function barcode($id){
        $product = DB::table('products')->find($id);
        return view('barcode', compact('product'));
    }
}
