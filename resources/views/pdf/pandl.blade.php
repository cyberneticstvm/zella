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
        <h5>PROFIT & LOSS REPORT</h5>
        <p>P&L Detailed Report Between {{ $inputs[0] }} and {{ $inputs[1] }}</p>
    </center>
    <table width="100%" class="bordered" cellspacing="0" cellpadding="0">
        <thead><tr><th>Invoice No.</th><th>Product Name</th><th>Qty</th><th>Purchase Rate/Qty</th><th>Sales Rate/Qty</th><th>Purchase Total</th><th>Sales Total</th><th>Profit</th></tr>
        <tbody>
            @php $etot=0; $itot=0; $ptot=0; @endphp
            @foreach($sales as $record)
            <tr>
                <td>{{ $record->sales_id }}</td>
                <td>{{ $record->name }}</td>
                <td>{{ $record->qty }}</td>
                <td class="text-right">{{ $record->prate }}</td>
                <td class="text-right">{{ $record->srate }}</td>
                <td class="text-right">{{ $record->expense }}</td>
                <td class="text-right">{{ $record->income }}</td>
                <td class="text-right">{{ number_format($record->income-$record->expense, 2) }}</td>
            </tr>
            @php 
                $etot += $record->expense; $itot += $record->income; $ptot += $record->income-$record->expense
            @endphp         
            @endforeach
            <tr><td colspan="5" class="text-right fw-bold">Total</td><td class="text-right fw-bold">{{ number_format($etot, 2) }}</td><td class="text-right fw-bold">{{ number_format($itot, 2) }}</td><td class="text-right fw-bold">{{ number_format($ptot, 2) }}</td></tr>
            <tr><td colspan="5" class="text-right fw-bold">Card Fee</td><td colspan="3" class="text-right fw-bold">{{ number_format($card_fee, 2) }}</td></tr>
            <!--<tr><td colspan="5" class="text-right fw-bold">Net Profit / Loss</td><td colspan="3" class="text-right fw-bold">{{ number_format($ptot - $expenses, 2) }}</td></tr>-->
        </tbody>
    </table>
</body>
</html>