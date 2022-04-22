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
        <h5>PURCHASE INVOICE</h5>
    </center>
    <table width="100%">
        <tbody>
            <tr><td width="25%">Supplier Name:</td><td width="35%">{{ $supplier->name }}</td><td width="25%">Zella Invoice No<td><td>{{ $purchase->id }}</td></tr>
            <tr><td>Supplier Invoice Number:</td><td>{{ $purchase->invoice_number }}</td><td>Delivery Date<td><td>{{ ($purchase->delivery_date) ? date('d/M/Y', strtotime($purchase->delivery_date)) : '' }}</td></tr>
        <tbody>
    </table>
    <table width="100%" class="bordered" cellspacing="0" cellpadding="0">
        <thead><tr><th>SL No.</th><th width="50%">Item Description</th><th>Qty</th><th>Rate</th><th>Amount</th></tr>
        <tbody>
            @php $c = 1; $tot = 0; @endphp
            @foreach($purchases as $row)
            <tr>
                <td>{{ $c++ }}</td>
                <td>{{ $row->name }}</td>
                <td class="text-right">{{ $row->qty }}</td>
                <td class="text-right">{{ $row->price }}</td>
                <td class="text-right">{{ number_format($row->total, 2) }}</td>
            </tr>
            {{ $tot += $row->total }}           
            @endforeach
            <tr><td colspan="4" class="text-right">Total</td><td class="text-right"><b>{{ number_format($tot, 2) }}</b></td></tr>  
        </tbody>
    </table>
    <pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre />
    <pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre /><pre />
    <center><img src="data:image/png;base64, {!! $qrcode !!}"></center>
</body>
</html>