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
        <h5>PURCHASE RETURN REPORT</h5>
        <p>Delivery Date Between {{ $inputs[0] }} and {{ $inputs[1] }}</p>
    </center>
    <table width="100%" class="bordered" cellspacing="0" cellpadding="0">
        <thead><tr><th>SL No.</th><th>Zella Invoice</th><th>Supplier Invoice</th><th>Supplier Name</th><th>Order Date</th><th>Delivery Date</th><th>Payment Mode</th><th>Invoice Total</th></tr>
        <tbody>
            @php $c = 1; $tot = 0; @endphp
            @foreach($purchases as $purchase)
            <tr>
                <td>{{ $c++ }}</td>
                <td>{{ $purchase->id }}</td>
                <td>{{ $purchase->invoice_number }}</td>
                <td>{{ $purchase->sname }}</td>
                <td>{{ ($purchase->order_date) ? date('d/M/Y', strtotime($purchase->order_date)) : '' }}</td>
                <td>{{ ($purchase->delivery_date) ? date('d/M/Y', strtotime($purchase->delivery_date)) : '' }}</td>
                <td>{{ $purchase->payment_mode }}</td>
                <td class="text-right">{{ $purchase->total }}</td>
            </tr>
            {{ $tot += $purchase->total}}           
            @endforeach
            <tr><td colspan="7" class="text-right"><b>Total</b></td><td class="text-right"><b>{{ number_format($tot, 2) }}</b></td></tr>
        </tbody>
    </table>
</body>
</html>