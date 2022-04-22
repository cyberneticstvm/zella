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
        <h5>EXPENSE REPORT</h5>
        <p>Expense Date Between {{ $inputs[0] }} and {{ $inputs[1] }} for {{ strtoupper($inputs[2]) }}</p>
    </center>
    <table width="100%" class="bordered" cellspacing="0" cellpadding="0">
        <thead><tr><th>SL No.</th><th>Date</th><th>Department</th><th>Description</th><th>Amount</th></tr>
        <tbody>
            @php $c = 1; $tot = 0; @endphp
            @foreach($expenses as $expense)
            <tr>
            <td>{{ $c++ }}</td>                                         
            <td>{{ $expense->edate }}</td>           
            <td>{{ $expense->department }}</td>           
            <td>{{ $expense->description }}</td>           
            <td class="text-right">{{ number_format($expense->amount, 2) }}</td>           
            </tr>
            {{ $tot += $expense->amount}}           
            @endforeach
            <tr><td colspan="4" class="text-right"><b>Total</b></td><td class="text-right"><b>{{ number_format($tot, 2) }}</b></td></tr>
        </tbody>
    </table>
</body>
</html>