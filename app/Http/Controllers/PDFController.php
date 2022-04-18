<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QrCode;
use PDF;
use DB;

class PDFController extends Controller
{
    private $settings;

    public function __construct(){
        $this->settings = DB::table('settings')->find(1);
    }

    public function salesinvoice($id){
        //$qrcode = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate('https://zellaboutiqueuae.com'));
        $sale = DB::table('sales')->find($id);
        $settings = $this->settings;       
        $sales = DB::table('sales_details as s')->leftJoin('products as p', 'p.id', '=', 's.product')->select('s.qty', 's.price', 's.total', 's.vat_percentage', 'p.name', 'p.vat_applicable')->where('s.sales_id', $id)->get();      
        $pdf = PDF::loadView('/pdf/sales-invoice', compact('sale', 'sales', 'settings'));
        return $pdf->stream('sales-invoice.pdf', array("Attachment"=>0));
    }
}
