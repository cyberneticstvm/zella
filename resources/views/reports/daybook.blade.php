@extends("base")

@section("content")
<!-- Body: Header -->
<div class="body-header d-flex py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="fs-4 mt-1 mb-0">Daybook</h1>
                <!--<small class="text-muted">You have 12 new messages and 7 new notifications.</small>-->
            </div>
        </div>
    </div>
</div>
<!-- Body: Body -->
<div class="body d-flex">
    <div class="container">        
        <div class="row">
            <div class="col-12">
                <!-- card: Calendar -->
                <div class="card mb-2">
                    <div class="card-body p-4">
                        <div class="mt-5">
                            <table id="" class="table table-sm display dataTable table-hover"><thead><tr><th>Particulars</th><th>Amount</th></tr></thead><tbody>
                            <tr><td colspan='2'>SALES</td></tr>
                            @foreach($sales as $sale)
                            <tr>
                                <td>{{ $sale->customer_name }}</td>
                                <td>{{ $sale->order_total }}</td>
                            </tr>
                            @endforeach
                            <tr><td colspan='2'>PURCHASES</td></tr>
                            @foreach($purchases as $purchase)
                            @php $ptotal = DB::table('purchase_details')->where('purchase_id', $purchase->id)->where('is_return', 0)->sum('total'); @endphp
                            <tr>
                                <td>{{ $purchase->invoice_number }}</td>
                                <td>{{ $ptotal }}</td>
                            </tr>
                            @endforeach
                            <tr><td colspan='2'>EXPENSES</td></tr>
                            @foreach($expenses as $expense)
                            <tr>
                                <td>{{ $expense->description }}</td>
                                <td>{{ $expense->amount }}</td>
                            </tr>
                            @endforeach
                            </tbody></table>
                        </div>
                    </div>
                </div> <!-- .Card End -->
            </div>
        </div> <!-- Row end  -->
    </div>
</div>
@endsection