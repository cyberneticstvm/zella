<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class ReportsController extends Controller
{
    private $settings;

    function __construct(){
        $this->settings = DB::table('settings')->find(1);

        $this->middleware('permission:expense-report', ['only' => ['showExpense','getExpense']]);
        $this->middleware('permission:sales-report', ['only' => ['showSales','getSales']]);
        $this->middleware('permission:sales-return-report', ['only' => ['showSalesReturn','getSalesReturn']]);
        $this->middleware('permission:purchase-report', ['only' => ['showPurchase','getPurchase']]);
        $this->middleware('permission:purchase-return-report', ['only' => ['showPurchaseReturn','getPurchaseReturn']]);
        $this->middleware('permission:pandl-report', ['only' => ['showPandL','getPandL']]);
        $this->middleware('permission:stockin-report', ['only' => ['showStockIn','getStockIn']]);
        $this->middleware('permission:stockout-report', ['only' => ['showStockOut','getStockOut']]);
        $this->middleware('permission:stockinhand-report', ['only' => ['getStockInHand']]);
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
        $product = (!empty($inputs[2])) ? $inputs[2] : NULL;
        $pmode = (!empty($inputs[3])) ? $inputs[3] : NULL;
        $pstatus = (!empty($inputs[4])) ? $inputs[4] : NULL;

        $sales = DB::table('sales AS s')->leftJoin('sales_details AS sd', 's.id', 'sd.sales_id')->selectRaw("s.id, DATE_FORMAT(s.sold_date, '%d/%b/%Y') AS sdate, s.customer_name, s.contact_number, s.address, s.payment_status, s.payment_mode, CASE WHEN sd.vat_percentage > 0 THEN (SUM(sd.qty*sd.price)+((SUM(sd.qty*sd.price)*sd.vat_percentage)/100)) - s.discount ELSE SUM(sd.qty*sd.price) - s.discount END AS total1, s.order_total as total")->where('s.is_dead_stock', 0)->where('sd.is_return', 0)->whereBetween('s.sold_date', [$from, $to])->when(isset($product), function($query) use ($request, $product){
            return $query->where('sd.product', $product);
        })->when(isset($pmode), function($query) use ($request, $pmode){
            return $query->where('s.payment_mode', $pmode);
        })->when(isset($pstatus), function($query) use ($request, $pstatus){
            return $query->where('s.payment_status', $pstatus);
        })->groupBy('s.id', 's.customer_name', 's.contact_number', 's.address', 's.payment_status', 's.payment_mode', 's.sold_date', 's.discount', 's.order_total', 'sd.vat_percentage')->get();

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

        $sales = DB::table('sales AS s')->leftJoin('sales_details AS sd', 's.id', 'sd.sales_id')->selectRaw("s.id, s.customer_name, s.contact_number, s.address, DATE_FORMAT(s.sold_date, '%d/%b/%Y') AS sdate, CASE WHEN sd.vat_percentage > 0 THEN (SUM(sd.qty*sd.price)+((SUM(sd.qty*sd.price)*sd.vat_percentage)/100)) ELSE SUM(sd.qty*sd.price) END AS total")->where('sd.is_return', 1)->whereBetween('sd.return_date', [$from, $to])->when(isset($request->product), function($query) use ($request){
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

        $sales = DB::table('sales_details AS sd')->leftJoin('products AS pr', 'pr.id', '=', 'sd.product')->leftJoin('sales AS sa', 'sd.sales_id', '=', 'sa.id')->selectRaw("sd.sales_id, pr.name, pr.purchase_price as prate, pr.selling_price as srate, sd.qty, sum(sd.total) AS income, sum(sd.qty)*pr.purchase_price AS expense")->whereBetween('sa.sold_date', [$from, $to])->where('sd.is_return', 0)->where('sa.payment_status', 'paid')->groupBy('sd.sales_id', 'sd.product', 'pr.name', 'sd.qty', 'pr.purchase_price', 'pr.selling_price', 'pr.purchase_price')->get();
        $expenses = DB::table('expenses')->whereBetween('expense_date', [$from, $to])->sum('amount');
        $card_fee = DB::table('sales_details AS sd')->join('sales AS sa', 'sd.sales_id', '=', 'sa.id')->selectRaw("sum(sd.total)-sa.order_total as card_fee")->whereBetween('sa.sold_date', [$from, $to])->where('sd.is_return', 0)->where('sa.payment_status', 'paid')->sum('card_fee');
        return view('reports.pandl', compact('expenses', 'inputs', 'sales', 'card_fee'));
    }

    public function showStockIn(){
        $inputs = []; $stockin = [];
        $suppliers = DB::table('suppliers')->get();
        $products = DB::table('products')->get();
        return view('reports.stockin', compact('inputs', 'suppliers', 'products', 'stockin'));
    }

    public function getStockIn(Request $request){
        $this->validate($request, [
            'from_date' => 'required',
            'to_date' => 'required',
        ]);
        $inputs = array($request->from_date, $request->to_date, $request->supplier, $request->product);
        $from = (!empty($request->from_date)) ? Carbon::createFromFormat('d/M/Y', $request->from_date)->format('Y-m-d') : NULL;
        $to = (!empty($request->to_date)) ? Carbon::createFromFormat('d/M/Y', $request->to_date)->format('Y-m-d') : NULL;
        $stockin = DB::table('purchase_details as pd')->leftJoin('purchases as p', 'pd.purchase_id', '=', 'p.id')->leftJoin('products as pr', 'pd.product', '=', 'pr.id')->leftJoin('suppliers as s', 's.id', '=', 'p.supplier')->selectRaw("p.id, p.invoice_number, s.name as supplier, pr.name as product, DATE_FORMAT(p.order_date, '%d/%b/%Y') AS odate, DATE_FORMAT(p.delivery_date, '%d/%b/%Y') AS ddate, p.payment_mode, pd.qty, pd.price, pd.total")->whereBetween('p.delivery_date', [$from, $to])->when(isset($request->supplier), function($query) use ($request){
            return $query->where('p.supplier', $request->supplier);
        })->when(isset($request->product), function($query) use ($request){
            return $query->where('pd.product', $request->product);
        })->get();
        $suppliers = DB::table('suppliers')->get();
        $products = DB::table('products')->get();
        return view('reports.stockin', compact('inputs', 'stockin', 'suppliers', 'products'));
    }

    public function showStockOut(){
        $inputs = []; $stockout = [];
        $products = DB::table('products')->get();
        return view('reports.stockout', compact('inputs', 'products', 'stockout'));
    }

    public function getStockOut(Request $request){
        $this->validate($request, [
            'from_date' => 'required',
            'to_date' => 'required',
        ]);
        $inputs = array($request->from_date, $request->to_date, $request->product);
        $from = (!empty($request->from_date)) ? Carbon::createFromFormat('d/M/Y', $request->from_date)->format('Y-m-d') : NULL;
        $to = (!empty($request->to_date)) ? Carbon::createFromFormat('d/M/Y', $request->to_date)->format('Y-m-d') : NULL;
        $stockout = DB::table('sales as s')->leftJoin('sales_details as sd', 's.id', '=', 'sd.sales_id')->leftJoin('products as p', 'p.id', '=', 'sd.product')->selectRaw("s.id, s.customer_name, p.name AS product,  DATE_FORMAT(s.sold_date, '%d/%b/%Y') AS sdate, s.payment_mode, sd.qty, sd.price, sd.total")->whereBetween('s.sold_date', [$from, $to])->when(isset($request->product), function($query) use ($request){
            return $query->where('sd.product', $request->product);
        })->get();
        $products = DB::table('products')->get();
        return view('reports.stockout', compact('inputs', 'stockout', 'products'));
    }

    public function getStockInHand(){
        $products = DB::table('products')->get();
        return view('reports.stockinhand', compact('products'));
    }

    public function getStockInHandCollection(){
        $collections = DB::table('collections')->get();
        return view('reports.stockinhandc', compact('collections'));
    }

    public function dayBook(){
        $sales = DB::table('sales as s')->leftJoin('sales_details as sd', 's.id', '=', 'sd.sales_id')->selectRaw("CASE WHEN s.card_fee > 0 THEN (SUM(sd.total)-s.discount)-((SUM(sd.total)-s.discount)*s.card_fee)/100 ELSE SUM(sd.total)-s.discount END AS order_total, s.customer_name")->whereDate('s.sold_date', Carbon::today())->groupBy('sd.sales_id', 's.card_fee', 's.discount', 's.customer_name')->get();
        $sales_tot = $sales->sum('order_total');
        $purchases = DB::table('purchases')->whereDate('delivery_date', Carbon::today())->get();
        $expenses = DB::table('expenses')->whereDate('expense_date', Carbon::today())->get();
        $exp_tot = $expenses->sum('amount');
        return view('reports.daybook', compact('sales', 'purchases', 'expenses', 'sales_tot', 'exp_tot'));
    }
}
