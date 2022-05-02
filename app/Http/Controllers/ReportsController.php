<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class ReportsController extends Controller
{
    private $settings;

    public function __construct(){
        $this->settings = DB::table('settings')->find(1);
    }
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
        $inputs = array($request->from_date, $request->to_date, $request->product, $request->payment_mode, $request->payment_status);
        $from = (!empty($request->from_date)) ? Carbon::createFromFormat('d/M/Y', $request['from_date'])->format('Y-m-d') : NULL;
        $to = (!empty($request->to_date)) ? Carbon::createFromFormat('d/M/Y', $request['to_date'])->format('Y-m-d') : NULL;

        $sales = DB::table('sales AS s')->leftJoin('sales_details AS sd', 's.id', 'sd.sales_id')->selectRaw("s.id, s.customer_name, s.contact_number, s.address, s.payment_status, DATE_FORMAT(s.sold_date, '%d/%b/%Y') AS sdate, s.payment_mode, CASE WHEN sd.vat_percentage > 0 THEN (SUM(sd.qty*sd.price)+((SUM(sd.qty*sd.price)*sd.vat_percentage)/100)) - s.discount ELSE SUM(sd.qty*sd.price) - s.discount END AS total")->where('sd.is_return', 0)->whereBetween('s.sold_date', [$from, $to])->when(isset($request->product), function($query) use ($request){
            return $query->where('sd.product', $request->product);
        })->when(isset($request->payment_mode), function($query) use ($request){
            return $query->where('s.payment_mode', $request->payment_mode);
        })->when(isset($request->payment_status), function($query) use ($request){
            return $query->where('s.payment_status', $request->payment_status);
        })->groupBy('s.id', 's.customer_name', 's.contact_number', 's.address', 's.payment_status', 's.sold_date', 's.payment_mode', 's.discount', 'sd.vat_percentage')->get();

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

        $sales = DB::table('sales AS s')->leftJoin('sales_details AS sd', 's.id', 'sd.sales_id')->selectRaw("s.id, s.customer_name, s.contact_number, s.address, DATE_FORMAT(s.sold_date, '%d/%b/%Y') AS sdate, CASE WHEN sd.vat_percentage > 0 THEN (SUM(sd.qty*sd.price)+((SUM(sd.qty*sd.price)*sd.vat_percentage)/100)) ELSE SUM(sd.qty*sd.price) END AS total")->where('sd.is_return', 1)->whereBetween('s.sold_date', [$from, $to])->when(isset($request->product), function($query) use ($request){
            return $query->where('sd.product', $request->product);
        })->groupBy('s.id', 's.customer_name', 's.contact_number', 's.address', 's.sold_date', 'sd.vat_percentage')->get();

        $products = DB::table('products')->get();
        return view('reports.sales-return', compact('products', 'sales', 'inputs'));
    }

    public function showExpense(){
        $inputs = []; $expenses = [];
        return view('reports.expense', compact('inputs', 'expenses'));
    }

    public function getExpense(Request $request){
        $this->validate($request, [
            'from_date' => 'required',
            'to_date' => 'required',
        ]);
        $inputs = array($request->from_date, $request->to_date, $request->department);
        $from = (!empty($request->from_date)) ? Carbon::createFromFormat('d/M/Y', $request->from_date)->format('Y-m-d') : NULL;
        $to = (!empty($request->to_date)) ? Carbon::createFromFormat('d/M/Y', $request->to_date)->format('Y-m-d') : NULL;

        $expenses = DB::table('expenses')->selectRaw("DATE_FORMAT(expense_Date, '%d/%b/%Y') AS edate, amount, department, description")->whereBetween('expense_date', [$from, $to])->when(isset($request->department), function($query) use ($request){
            return $query->where('department', $request->department);
        })->get();
        return view('reports.expense', compact('expenses', 'inputs'));
    }

    public function showPandL(){
        $inputs = []; $expenses = [];
        return view('reports.pandl', compact('inputs', 'expenses'));
    }

    public function getPandL(Request $request){
        $this->validate($request, [
            'from_date' => 'required',
            'to_date' => 'required',
        ]);
        $inputs = array($request->from_date, $request->to_date);
        $from = (!empty($request->from_date)) ? Carbon::createFromFormat('d/M/Y', $request->from_date)->format('Y-m-d') : NULL;
        $to = (!empty($request->to_date)) ? Carbon::createFromFormat('d/M/Y', $request->to_date)->format('Y-m-d') : NULL;

        $sales = DB::table('sales_details AS sd')->leftJoin('products AS pr', 'pr.id', '=', 'sd.product')->leftJoin('sales AS sa', 'sd.sales_id', '=', 'sa.id')->selectRaw("sd.sales_id, pr.name, pr.purchase_price as prate, pr.selling_price as srate, sd.qty, sum(sd.total)-sa.discount AS income, sum(sd.qty)*pr.purchase_price AS expense")->whereBetween('sa.sold_date', [$from, $to])->where('sd.is_return', 0)->where('sa.payment_status', 'paid')->groupBy('sd.sales_id', 'sd.product', 'pr.name', 'sd.qty', 'pr.purchase_price', 'pr.selling_price', 'sa.discount', 'pr.purchase_price')->get();
        $expenses = DB::table('expenses')->whereBetween('expense_date', [$from, $to])->sum('amount');
        return view('reports.pandl', compact('expenses', 'inputs', 'sales'));
    }
}
