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
}
