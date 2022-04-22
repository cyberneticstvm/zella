<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class SearchController extends Controller
{
    public function showPurchase(){
        $inputs = []; $purchase = [];
        return view('search.purchase', compact('inputs', 'purchase'));
    }

    public function getPurchase(Request $request){
        $this->validate($request, [
            'invoice_number' => 'required',
        ]);
        $input = $request->all();
        $inputs = array($request->invoice_number);
        $purchase = DB::table('purchases')->find($request->invoice_number);
        if($purchase):
            $supplier = DB::table('suppliers')->find($purchase->supplier);
            return view('search.purchase', compact('inputs', 'purchase', 'supplier'));
        else:
            return redirect()->route('search.purchase')->withErrors('No records found.');
        endif;
    }

    public function showSales(){
        $sales = [];
        return view('search.sales', compact('sales'));
    }

    public function getSales(Request $request){
        $this->validate($request, [
            'invoice_number' => 'required',
        ]);
        $input = $request->all();
        $inputs = array($request->invoice_number);
        $sales = DB::table('sales')->find($request->invoice_number);
        if($sales):
            return view('search.sales', compact('inputs', 'sales'));
        else:
            return redirect()->route('search.sales')->withErrors('No records found.');
        endif;
    }

    public function showStockStatus(){
        $inputs = [];
        $products = DB::table('products')->get();
        return view('search.stock-status', compact('products', 'inputs'));
    }

    public function getStockStatus(Request $request){
        $this->validate($request, [
            'product' => 'required',
        ]);
        $input = $request->all();
        $inputs = array($request->product);
        $products = DB::table('products')->get();
        $qty_sold = DB::table('sales_details')->where('product', $request->product)->sum('qty');
        $qty_sreturn = DB::table('sales_details')->where('product', $request->product)->where('is_return', 1)->sum('qty');
        $qty_purchase = DB::table('purchase_details')->where('product', $request->product)->sum('qty');
        $qty_preturn = DB::table('purchase_details')->where('product', $request->product)->where('is_return', 1)->sum('qty');
        return view('search.stock-status', compact('inputs', 'qty_sold', 'qty_sreturn', 'qty_purchase', 'qty_preturn', 'products'));
    }
}
