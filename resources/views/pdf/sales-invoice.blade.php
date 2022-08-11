<?php
    $obj = new \ArPHP\I18N\Arabic();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Zella Boutique UAE</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style type="text/css">
        @font-face {
            font-family: 'notosans';
            src: url("{{ storage_path('/fonts/NotoSansArabic-Regular.ttf') }}") format("truetype");
        }
        table{
            font-size: 10px;
        }
        .bordered th, .bordered td{
            border: 1px solid #e6e6e6;
            padding: 2px;
        }
        .text-right{
            text-align: right;
        }
        .arab{
            font-family: 'notosans';
            font-weight: normal;
            font-size:10px;
        }
        .big{
            font-size: .7rem;
            margin-top: -10px;
        }
    </style>
</head>
<body>
    <center>
        <img src="./images/zella-logo-pdf.png" width="20%"/>
        <p class="arab big">{{ $obj->utf8Glyphs('الشخص الواحد ذ.م.م') }} {{ $obj->utf8Glyphs('زلة بطيق لتجارة الملابس والأقمشة شركة ') }}</p>
        <p>Phone: 0562659619, 0521734496</p>
        <p>INVOICE&nbsp;&nbsp;<span class="arab"> {{ $obj->utf8Glyphs('فاتورة') }} </span></p>
    </center>
    <table width="100%" cellspacing="0" cellpadding="0">
        <tbody>
            <tr><td width="30%">Mr. / Mrs. <span class="arab">{{ $obj->utf8Glyphs('السيدة') }}</span> / <span class="arab">{{ $obj->utf8Glyphs('السيد') }}</span> </td><td width="30%">{{ $sale->customer_name }}</td><td width="25%">Invoice No<td><td>{{ $sale->id }}</td></tr>
            <tr><td>Contact Number:</td><td>{{ $sale->contact_number }}</td><td>Invoice Date / <span class="arab">{{ $obj->utf8Glyphs('تاريخ') }}</span><td><td>{{ ($sale->sold_date) ? date('d/M/Y', strtotime($sale->sold_date)) : '' }}</td></tr>
            <tr><td>Address:</td><td colspan="3">{{ $sale->address }}</td></tr>
        <tbody>
    </table>
    <table width="100%" class="bordered" cellspacing="0" cellpadding="0">
        <thead><tr><th>SL No.</th><th width="50%">Item Description</th><th>Qty</th><th>Rate</th><th>VAT% %<span class="arab">{{ $obj->utf8Glyphs('ضريبة') }}</span></th><th>VAT Amount</th><th>Amount</th></tr>
        <tbody>
            @php $c = 1; $tot = 0; $vat_tot = 0; @endphp
            @foreach($sales as $row)
            @php
                $vat_percentage = $row->vat_percentage;
                $vat_amount = ($vat_percentage > 0) ? ($row->total*$vat_percentage)/100 : 0;
                $tot += $row->total+$vat_amount;
                $vat_tot += $vat_amount;
                $old = ($row->old_product > 0) ? DB::table('products')->find($row->old_product) : '';
            @endphp
            <tr>
                <td>{{ $c++ }}</td>
                <td>{{ $row->name }} {{ ($old && $old->name) ? ' (Exchange with '.$old->name.')' : '' }}</td>
                <td class="text-right">{{ $row->qty }}</td>
                <td class="text-right">{{ $row->price }}</td>
                <td class="text-right">{{ $vat_percentage }}</td>
                <td class="text-right">{{ number_format($vat_amount, 2) }}</td>
                <td class="text-right">{{ number_format($row->total+$vat_amount, 2) }}</td>
            </tr>           
            @endforeach
            <tr><td colspan="6" class="text-right">Sub Total / <span class="arab">{{ $obj->utf8Glyphs('المجموع الفرعي') }}</span></td><td class="text-right"><b>{{ number_format($tot, 2) }}</b></td></tr>  

            <tr><td colspan="6" class="text-right">VAT/<span class="arab">{{ $obj->utf8Glyphs('ضريبة') }}</span> (Included in Sub Total)</td><td class="text-right">{{ number_format($vat_tot, 2) }}</td></tr>

            <tr><td colspan="6" class="text-right">Discount</td><td class="text-right">{{ $sale->discount }}</td></tr>

            <tr><td colspan="6" class="text-right">Grand Total / <span class="arab">{{ $obj->utf8Glyphs('مجموع الدراهم') }}</span></td><td class="text-right"><b>{{ number_format($tot-$sale->discount, 2) }}</b></td></tr>
        </tbody>
    </table>
    <br />
    <table width="100%">
        <tr><td>Receiver's Sign</td><td class="text-right">Signature / <span class="arab">{{ $obj->utf8Glyphs('التوقيع') }}</span></td></tr>
    </table>
    <!--<center><img src="data:image/png;base64, {!! $qrcode !!}"></center>-->
</body>
</html>