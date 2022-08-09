@extends("base")

@section("content")
<!-- Body: Header -->
<div class="body-header d-flex py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="fs-4 mt-1 mb-0">Sales Register</h1>
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
                        <div class="text-right"><a href="/sales/create/"><i class="fa fa-plus text-primary"></i></a></div>
                        <table id="dataTbl" class="table display table-sm dataTable table-striped table-hover align-middle" style="width:100%">
                        <thead><tr><th>SL No.</th><th>Invoice Number</th><th>Customer Name</th><th>Contact Number</th><th>Address</th><th>Sold Date</th><th>Payment Status</th><th>Invoice</th><th>Return</th><th>Edit</th><th>Remove</th></tr></thead><tbody>
                        @php $i = 0; @endphp
                        @foreach($sales as $sale)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $sale->id }}</td>
                            <td>{{ $sale->customer_name }}</td>
                            <td>{{ $sale->contact_number }}</td>
                            <td>{{ $sale->address }}</td>
                            <td>{{ date('d/M/Y', strtotime($sale->sold_date)) }}</td>
                            <td>{{ $sale->payment_status }}</td>
                            <td><a class='btn btn-link' href="/sales-invoice/{{ $sale->id }}" target="_blank"><i class="fa fa-file-o text-muted"></i></a></td>
                            <td class="text-center"><a href="{{ route('sales.return1', $sale->id) }}"><i class="fa fa-undo text-info"></i></a></td>
                            <td><a class='btn btn-link' href="{{ route('sales.edit', $sale->id) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                            <td>
                                <form method="post" action="{{ route('sales.delete', $sale->id) }}">
                                    @csrf 
                                    @method("DELETE")
                                    <button type="submit" class="btn btn-link" onclick="javascript: return confirm('Are you sure want to delete this Sale Record?');"><i class="fa fa-trash text-danger"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        </tbody></table>
                    </div>
                </div> <!-- .Card End -->
            </div>
        </div> <!-- Row end  -->
    </div>
</div>
@endsection