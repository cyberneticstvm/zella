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
        $sales = DB::table('sales_details as s')->leftJoin('products as p', 'p.id', '=', 's.product')->select('s.qty', 's.price', 's.total', 's.vat_percentage', 'p.name', 'p.vat_applicable')->where('s.sales_id', $id)->get();      
        $pdf = PDF::loadView('/pdf/sales-invoice', compact('sale', 'sales', 'settings', 'qrcode'));
        return $pdf->stream('sales-invoice.pdf', array("Attachment"=>0));
    }

    public function products(){
        $products = DB::table('products as p')->leftJoin('collections as c', 'p.collection', '=', 'c.id')->select('p.name as pname', 'p.sku', 'p.selling_price', 'p.description', 'c.name as cname')->get();
        $pdf = PDF::loadView('/pdf/products', compact('products'));
        return $pdf->stream('products.pdf', array("Attachment"=>0));
    }

    public function purchase(Request $request){
        $inputs = explode(',', $request->inputs);
        $from = (!empty($inputs[0])) ? Carbon::createFromFormat('d/M/Y', $inputs[0])->format('Y-m-d') : NULL;
        $to = (!empty($inputs[1])) ? Carbon::createFromFormat('d/M/Y', $inputs[1])->format('Y-m-d') : NULL;
        $supplier = (!empty($inputs[2])) ? $inputs[2] : NULL;
        $product = (!empty($inputs[3])) ? $inputs[3] : NULL;

        $purchases = DB::table('purchases as p')->leftJoin('purchase_details as pd', 'p.id', 'pd.purchase_id')->leftJoin('suppliers as s', 'p.supplier', '=', 's.id')->selectRaw('p.id, p.invoice_number, p.order_date, p.delivery_date, p.payment_mode, s.name as sname, SUM(pd.total)+p.other_expense as total')->where('pd.is_return', 0)->whereBetween('p.delivery_date', [$from, $to])->when(isset($supplier), function($query) use ($request){
            return $query->where('p.supplier', $supplier);
        })->when(isset($product), function($query) use ($request){
            return $query->where('pd.product', $product);
        })->groupBy('p.id')->get();
        $pdf = PDF::loadView('/pdf/purchase', compact('purchases', 'inputs'));
        return $pdf->stream('purchase.pdf', array("Attachment"=>0));
    }
}
