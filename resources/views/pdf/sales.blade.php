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
        <h5>SALES REPORT</h5>
        <p>Sales Date Between {{ $inputs[0] }} and {{ $inputs[1] }}</p>
    </center>
    <table width="100%" class="bordered" cellspacing="0" cellpadding="0">
        <thead><tr><th>SL No.</th><th>Invoice Number</th><th>Date</th><th>Payment Mode</th><th>Payment Status</th><th>Customer Name</th><th>Contact Number</th><th>Address</th><th>Invoice Total</th></tr>
        <tbody>
            @php $c = 1; $tot = 0; @endphp
            @foreach($sales as $sale)
            <tr>
            <td>{{ $c++ }}</td>                                
            <td>{{ $sale->id }}</td>           
            <td>{{ $sale->sdate }}</td>           
            <td>{{ $sale->payment_mode }}</td>           
            <td>{{ $sale->payment_status }}</td>           
            <td>{{ $sale->customer_name }}</td>           
            <td>{{ $sale->contact_number }}</td>           
            <td>{{ $sale->address }}</td>           
            <td class="text-right">{{ number_format($sale->total, 2) }}</td>
            </tr>
            {{ $tot += $sale->total}}           
            @endforeach
            <tr><td colspan="8" class="text-right"><b>Total</b></td><td class="text-right"><b>{{ number_format($tot, 2) }}</b></td></tr>
        </tbody>
    </table>
</body>
</html>