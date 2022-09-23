<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QrCode;
use PDF;
use Carbon\Carbon;
use DB;

class PDFController extends Controller
{
    private $settings, $qrcode;

    public function __construct(){
        $this->settings = DB::table('settings')->find(1);
        $this->qrcode = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate('https://zellaboutiqueuae.com'));
    }

    public function salesinvoice($id){
        $sale = DB::table('sales')->find($id);
        $settings = $this->settings; $qrcode =  $this->qrcode;      
        $sales = DB::table('sales_details as s')->leftJoin('products as p', 'p.id', '=', 's.product')->select('s.id', 's.product', 's.qty', 's.price', 's.total', 's.vat_percentage', 's.old_product', 's.return_date', 's.is_return', 'p.name', 'p.vat_applicable')->where('s.sales_id', $id)->get();      
        $pdf = PDF::loadView('/pdf/sales-invoice', compact('sale', 'sales', 'settings', 'qrcode'));
        return $pdf->stream('sales-invoice.pdf', array("Attachment"=>0));
    }

    public function purchaseinvoice($id){
        $purchase = DB::table('purchases')->find($id);
        $supplier = DB::table('suppliers')->find($purchase->supplier);
        $settings = $this->settings; $qrcode =  $this->qrcode;    
        $purchases = DB::table('purchase_details as pu')->leftJoin('products as p', 'p.id', '=', 'pu.product')->select('pu.qty', 'pu.price', 'pu.total', 'p.name', 'p.vat_applicable')->where('pu.purchase_id', $id)->get();      
        $pdf = PDF::loadView('/pdf/purchase-invoice', compact('purchase', 'purchases', 'settings', 'qrcode', 'supplier'));
        return $pdf->stream('purchase-invoice.pdf', array("Attachment"=>0));
    }

    public function products(){
        $products = DB::table('products as p')->leftJoin('collections as c', 'p.collection', '=', 'c.id')->select('p.name as pname', 'p.sku', 'p.selling_price', 'p.description', 'c.name as cname')->get();
        $pdf = PDF::loadView('/pdf/products', compact('products'));
        return $pdf->stream('products.pdf', array("Attachment"=>0));
    }

    public function barcodes(){
        $products = DB::table('products')->get();
        $pdf = PDF::loadView('/pdf/barcodes', compact('products'));
        return $pdf->stream('barcodes.pdf', array("Attachment"=>0));
    }

    public function purchase(Request $request){
        $inputs = explode(',', $request->inputs);
        $from = (!empty($inputs[0])) ? Carbon::createFromFormat('d/M/Y', $inputs[0])->format('Y-m-d') : NULL;
        $to = (!empty($inputs[1])) ? Carbon::createFromFormat('d/M/Y', $inputs[1])->format('Y-m-d') : NULL;
        $supplier = (!empty($inputs[2])) ? $inputs[2] : NULL;
        $product = (!empty($inputs[3])) ? $inputs[3] : NULL;

        $purchases = DB::table('purchases as p')->leftJoin('purchase_details as pd', 'p.id', 'pd.purchase_id')->leftJoin('suppliers as s', 'p.supplier', '=', 's.id')->selectRaw('p.id, p.invoice_number, p.order_date, p.delivery_date, p.payment_mode, s.name as sname, SUM(pd.total)+p.other_expense as total')->where('pd.is_return', 0)->whereBetween('p.delivery_date', [$from, $to])->when(isset($supplier), function($query) use ($request, $supplier){
            return $query->where('p.supplier', $supplier);
        })->when(isset($product), function($query) use ($request, $product){
            return $query->where('pd.product', $product);
        })->groupBy('p.id', 'p.invoice_number', 'p.order_date', 'p.delivery_date', 'p.payment_mode', 's.name', 'p.other_expense')->get();
        $pdf = PDF::loadView('/pdf/purchase', compact('purchases', 'inputs'));
        return $pdf->stream('purchase.pdf', array("Attachment"=>0));
    }

    public function purchasereturn(Request $request){
        $inputs = explode(',', $request->inputs);
        $from = (!empty($inputs[0])) ? Carbon::createFromFormat('d/M/Y', $inputs[0])->format('Y-m-d') : NULL;
        $to = (!empty($inputs[1])) ? Carbon::createFromFormat('d/M/Y', $inputs[1])->format('Y-m-d') : NULL;
        $supplier = (!empty($inputs[2])) ? $inputs[2] : NULL;
        $product = (!empty($inputs[3])) ? $inputs[3] : NULL;

        $purchases = DB::table('purchases as p')->leftJoin('purchase_details as pd', 'p.id', 'pd.purchase_id')->leftJoin('suppliers as s', 'p.supplier', '=', 's.id')->selectRaw('p.id, p.invoice_number, p.order_date, p.delivery_date, p.payment_mode, s.name as sname, SUM(pd.qty*pd.price) as total')->where('pd.is_return', 1)->whereBetween('p.delivery_date', [$from, $to])->when(isset($supplier), function($query) use ($request, $supplier){
            return $query->where('p.supplier', $supplier);
        })->when(isset($product), function($query) use ($request, $product){
            return $query->where('pd.product', $product);
        })->groupBy('p.id', 'p.invoice_number', 'p.order_date', 'p.delivery_date', 'p.payment_mode', 's.name')->get();

        $pdf = PDF::loadView('/pdf/purchase-return', compact('purchases', 'inputs'));
        return $pdf->stream('purchase-return.pdf', array("Attachment"=>0));
    }

    public function sales(Request $request){
        $inputs = explode(',', $request->inputs);
        $from = (!empty($inputs[0])) ? Carbon::createFromFormat('d/M/Y', $inputs[0])->format('Y-m-d') : NULL;
        $to = (!empty($inputs[1])) ? Carbon::createFromFormat('d/M/Y', $inputs[1])->format('Y-m-d') : NULL;
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

        $pdf = PDF::loadView('/pdf/sales', compact('sales', 'inputs'));
        return $pdf->stream('sales.pdf', array("Attachment"=>0));
    }

    public function salesreturn(Request $request){
        $inputs = explode(',', $request->inputs);
        $from = (!empty($inputs[0])) ? Carbon::createFromFormat('d/M/Y', $inputs[0])->format('Y-m-d') : NULL;
        $to = (!empty($inputs[1])) ? Carbon::createFromFormat('d/M/Y', $inputs[1])->format('Y-m-d') : NULL;
        $product = (!empty($inputs[2])) ? $inputs[2] : NULL;

        $sales = DB::table('sales AS s')->leftJoin('sales_details AS sd', 's.id', 'sd.sales_id')->selectRaw("s.id, s.customer_name, s.contact_number, s.address, DATE_FORMAT(s.sold_date, '%d/%b/%Y') AS sdate, CASE WHEN sd.vat_percentage > 0 THEN (SUM(sd.qty*sd.price)+((SUM(sd.qty*sd.price)*sd.vat_percentage)/100)) ELSE SUM(sd.qty*sd.price) END AS total")->where('sd.is_return', 1)->whereBetween('s.sold_date', [$from, $to])->when(isset($product), function($query) use ($request, $product){
            return $query->where('sd.product', $product);
        })->groupBy('s.id', 's.customer_name', 's.contact_number', 's.address', 's.sold_date', 'sd.vat_percentage')->get();

        $pdf = PDF::loadView('/pdf/sales-return', compact('sales', 'inputs'));
        return $pdf->stream('sales-return.pdf', array("Attachment"=>0));
    }

    public function expense(Request $request){
        $inputs = explode(',', $request->inputs);
        $from = (!empty($inputs[0])) ? Carbon::createFromFormat('d/M/Y', $inputs[0])->format('Y-m-d') : NULL;
        $to = (!empty($inputs[1])) ? Carbon::createFromFormat('d/M/Y', $inputs[1])->format('Y-m-d') : NULL;
        $department = (!empty($inputs[2])) ? $inputs[2] : NULL;

        $expenses = DB::table('expenses')->selectRaw("DATE_FORMAT(expense_Date, '%d/%b/%Y') AS edate, amount, department, description")->whereBetween('expense_date', [$from, $to])->when(isset($department), function($query) use ($department){
            return $query->where('department', $department);
        })->get();

        $pdf = PDF::loadView('/pdf/expense', compact('expenses', 'inputs'));
        return $pdf->stream('expense.pdf', array("Attachment"=>0));
    }

    public function pandl(Request $request){
        $inputs = explode(',', $request->inputs);
        $from = (!empty($inputs[0])) ? Carbon::createFromFormat('d/M/Y', $inputs[0])->format('Y-m-d') : NULL;
        $to = (!empty($inputs[1])) ? Carbon::createFromFormat('d/M/Y', $inputs[1])->format('Y-m-d') : NULL;
        $sales = DB::table('sales_details AS sd')->leftJoin('products AS pr', 'pr.id', '=', 'sd.product')->leftJoin('sales AS sa', 'sd.sales_id', '=', 'sa.id')->selectRaw("sd.sales_id, pr.name, pr.purchase_price as prate, pr.selling_price as srate, sd.qty, sum(sd.total) as income, sum(sd.qty)*pr.purchase_price AS expense")->whereBetween('sa.sold_date', [$from, $to])->where('sd.is_return', 0)->where('sa.is_dead_stock', 0)->groupBy('sd.sales_id', 'sd.product', 'pr.name', 'sd.qty', 'pr.purchase_price', 'pr.selling_price', 'pr.purchase_price')->get();
        $expenses = DB::table('expenses')->whereBetween('expense_date', [$from, $to])->sum('amount');
        $card_fee = DB::table('sales_details AS sd')->join('sales AS sa', 'sd.sales_id', '=', 'sa.id')->selectRaw("sum(sd.total)-sa.order_total as card_fee")->whereBetween('sa.sold_date', [$from, $to])->where('sd.is_return', 0)->where('sa.payment_status', 'paid')->sum('card_fee');
        $pdf = PDF::loadView('/pdf/pandl', compact('sales', 'inputs', 'expenses', 'card_fee'));
        return $pdf->stream('pandl.pdf', array("Attachment"=>0));
    }

    public function barcode($id){
        $product = DB::table('products')->find($id);
        $pdf = PDF::loadView('/pdf/barcode', compact('product'));
        return $pdf->stream('barcode.pdf', array("Attachment"=>0));
    }
}
