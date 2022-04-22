<!DOCTYPE html>
<html>
<head>
    <title>Zella Boutique UAE</title>
    <style>
        table{
            font-size: 15px;
        }
        .bordered th, .bordered td{
            border: 1px solid #e6e6e6;
            padding: 5px;
        }
        .text-right{
            text-align: right;
        }
    </style>
</head>
<body>
    <center>
        <img src="./images/zella-logo-pdf.png" width="25%"/>
        <p>Phone: 0562659619, 0521734496</p>
        <h5>SALES INVOICE</h5>
    </center>
    <table width="100%">
        <tbody>
            <tr><td width="25%">Customer Name:</td><td width="45%">{{ $sale->customer_name }}</td><td width="15%">Invoice No<td><td>{{ $sale->id }}</td></tr>
            <tr><td>Contact Number:</td><td>{{ $sale->contact_number }}</td><td>Invoice Date<td><td>{{ ($sale->sold_date) ? date('d/M/Y', strtotime($sale->sold_date)) : '' }}</td></tr>
            <tr><td>Address:</td><td colspan="3">{{ $sale->address }}</td></tr>
        <tbody>
    </table>
    <table width="100%" class="bordered" cellspacing="0" cellpadding="0">
        <thead><tr><th>SL No.</th><th width="50%">Item Description</th><th>Qty</th><th>Rate</th><th>VAT%</th><th>VAT Amount</th><th>Amount</th></tr>
        <tbody>
            @php $c = 1; $tot = 0; $vat_tot = 0; @endphp
            @foreach($sales as $row)
            @php
                $vat_percentage = $row->vat_percentage;
                $vat_amount = ($vat_percentage > 0) ? ($row->total*$vat_percentage)/100 : 0;
                $tot += $row->total+$vat_amount;
                $vat_tot += $vat_amount;
            @endphp
            <tr>
                <td>{{ $c++ }}</td>
                <td>{{ $row->name }}</td>
                <td class="text-right">{{ $row->qty }}</td>
                <td class="text-right">{{ $row->price }}</td>
                <td class="text-right">{{ $vat_percentage }}</td>
                <td class="text-right">{{ number_format($vat_amount, 2) }}</td>
                <td class="text-right">{{ number_format($row->total+$vat_amount, 2) }}</td>
            </tr>           
            @endforeach
            <tr><td colspan="6" class="text-right">Sub Total</td><td class="text-right"><b>{{ number_format($tot, 2) }}</b></td></tr>  

            <tr><td colspan="6" class="text-right">VAT (Included in Sub Total)</td><td class="text-right">{{ number_format($vat_tot, 2) }}</td></tr>

            <tr><td colspan="6" class="text-right">Discount</td><td class="text-right">{{ $sale->discount }}</td></tr>

            <tr><td colspan="6" class="text-right">Grand Total</td><td class="text-right"><b>{{ number_format($tot-$sale->discount, 2) }}</b></td></tr>
        </tbody>
    </table>
    <br /><br /><br />
    <table width="100%">
        <tr><td>Receiver's Sign</td><td class="text-right">Signature</td></tr>
    </table>
    <!--<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate('http://google.com')) !!} ">-->
    <pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre />
    <pre /><pre /><pre /><pre /><pre />
    <center><img src="data:image/png;base64, {!! $qrcode !!}"></center>
</body>
</html>