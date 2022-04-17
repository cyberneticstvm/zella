<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use DB;
use QrCode;

class PDFController extends Controller
{
    public function salesinvoice(){
        $qrcode = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate('https://zellaboutiqueuae.com'));         
        $pdf = PDF::loadView('/pdf/sales-invoice', compact('qrcode'));
        return $pdf->stream('sales-invoice.pdf', array("Attachment"=>0));
    }
}
