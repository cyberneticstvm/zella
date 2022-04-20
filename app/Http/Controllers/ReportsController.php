<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class ReportsController extends Controller
{
    public function showPurchase(){
        $suppliers = DB::table('suppliers')->get();
        $products = DB::table('products')->get();
        $purchases = []; $inputs = [];
        return view('reports.purchase', compact('suppliers', 'products', 'purchases', 'inputs'));
    }

    public function getPurchase(Request $request){
        $this->validate($request, [
            'from_date' => 'required',
            'to_date' => 'required',
        ]);
        $inputs = array($request->from_date, $request->to_date, $request->supplier, $request->product);
        $from = (!empty($request->from_date)) ? Carbon::createFromFormat('d/M/Y', $request['from_date'])->format('Y-m-d') : NULL;
        $to = (!empty($request->to_date)) ? Carbon::createFromFormat('d/M/Y', $request['to_date'])->format('Y-m-d') : NULL;

        $purchases = DB::table('purchases as p')->leftJoin('purchase_details as pd', 'p.id', 'pd.purchase_id')->leftJoin('suppliers as s', 'p.supplier', '=', 's.id')->selectRaw('p.id, p.invoice_number, p.order_date, p.delivery_date, p.payment_mode, s.name as sname, SUM(pd.total)+p.other_expense as total')->where('pd.is_return', 0)->whereBetween('p.delivery_date', [$from, $to])->when(isset($request->supplier), function($query) use ($request){
            return $query->where('p.supplier', $request->supplier);
        })->when(isset($request->product), function($query) use ($request){
            return $query->where('pd.product', $request->product);
        })->groupBy('p.id', 'p.invoice_number', 'p.order_date', 'p.delivery_date', 'p.payment_mode', 's.name', 'p.other_expense')->get();

        $suppliers = DB::table('suppliers')->get();
        $products = DB::table('products')->get();
        return view('reports.purchase', compact('suppliers', 'products', 'purchases', 'inputs'));
    }

    public function showPurchaseReturn(){
        $suppliers = DB::table('suppliers')->get();
        $products = DB::table('products')->get();
        $purchases = []; $inputs = [];
        return view('reports.purchase-return', compact('suppliers', 'products', 'purchases', 'inputs'));
    }

    public function getPurchaseReturn(Request $request){
        $this->validate($request, [
            'from_date' => 'required',
            'to_date' => 'required',
        ]);
        $inputs = array($request->from_date, $request->to_date, $request->supplier, $request->product);
        $from = (!empty($request->from_date)) ? Carbon::createFromFormat('d/M/Y', $request['from_date'])->format('Y-m-d') : NULL;
        $to = (!empty($request->to_date)) ? Carbon::createFromFormat('d/M/Y', $request['to_date'])->format('Y-m-d') : NULL;

        $purchases = DB::table('purchases as p')->leftJoin('purchase_details as pd', 'p.id', 'pd.purchase_id')->leftJoin('suppliers as s', 'p.supplier', '=', 's.id')->selectRaw('p.id, p.invoice_number, p.order_date, p.delivery_date, p.payment_mode, s.name as sname, SUM(pd.qty*pd.price) as total')->where('pd.is_return', 1)->whereBetween('p.delivery_date', [$from, $to])->when(isset($request->supplier), function($query) use ($request){
            return $query->where('p.supplier', $request->supplier);
        })->when(isset($request->product), function($query) use ($request){
            return $query->where('pd.product', $request->product);
        })->groupBy('p.id', 'p.invoice_number', 'p.order_date', 'p.delivery_date', 'p.payment_mode', 's.name')->get();

        $suppliers = DB::table('suppliers')->get();
        $products = DB::table('products')->get();
        return view('reports.purchase-return', compact('suppliers', 'products', 'purchases', 'inputs'));
    }

    public function showSales(){
        $products = DB::table('products')->get();
        $sales = []; $inputs = [];
        return view('reports.sales', compact('products', 'sales', 'inputs'));
    }

    public function getSales(Request $request){
        $this->validate($request, [
            'from_date' => 'required',
            'to_date' => 'required',
        ]);
        $inputs = array($request->from_date, $request->to_date, $request->product);
        $from = (!empty($request->from_date)) ? Carbon::createFromFormat('d/M/Y', $request['from_date'])->format('Y-m-d') : NULL;
        $to = (!empty($request->to_date)) ? Carbon::createFromFormat('d/M/Y', $request['to_date'])->format('Y-m-d') : NULL;

        $sales = DB::table('sales AS s')->leftJoin('sales_details AS sd', 's.id', 'sd.sales_id')->selectRaw("s.id, s.customer_name, s.contact_number, s.address, DATE_FORMAT(s.sold_date, '%d/%b/%Y') AS sdate, SUM(sd.qty*sd.price) - s.discount AS total")->where('sd.is_return', 0)->whereBetween('s.sold_date', [$from, $to])->when(isset($request->product), function($query) use ($request){
            return $query->where('sd.product', $request->product);
        })->groupBy('s.id', 's.customer_name', 's.contact_number', 's.address', 's.sold_date', 's.discount')->get();

        $products = DB::table('products')->get();
        return view('reports.sales', compact('products', 'sales', 'inputs'));
    }

    public function showSalesReturn(){
        $products = DB::table('products')->get();
        $sales = []; $inputs = [];
        return view('reports.sales-return', compact('products', 'sales', 'inputs'));
    }

    public function getSalesReturn(Request $request){
        $this->validate($request, [
            'from_date' => 'required',
            'to_date' => 'required',
        ]);
        $inputs = array($request->from_date, $request->to_date, $request->product);
        $from = (!empty($request->from_date)) ? Carbon::createFromFormat('d/M/Y', $request['from_date'])->format('Y-m-d') : NULL;
        $to = (!empty($request->to_date)) ? Carbon::createFromFormat('d/M/Y', $request['to_date'])->format('Y-m-d') : NULL;

        $sales = DB::table('sales AS s')->leftJoin('sales_details AS sd', 's.id', 'sd.sales_id')->selectRaw("s.id, s.customer_name, s.contact_number, s.address, DATE_FORMAT(s.sold_date, '%d/%b/%Y') AS sdate, SUM(sd.qty*sd.price) AS total")->where('sd.is_return', 1)->whereBetween('s.sold_date', [$from, $to])->when(isset($request->product), function($query) use ($request){
            return $query->where('sd.product', $request->product);
        })->groupBy('s.id', 's.customer_name', 's.contact_number', 's.address', 's.sold_date')->get();

        $products = DB::table('products')->get();
        return view('reports.sales-return', compact('products', 'sales', 'inputs'));
    }
}
