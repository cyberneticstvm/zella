@extends("base")

@section("content")
<!-- Body: Header -->
<div class="body-header d-flex py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="fs-4 mt-1 mb-0">Search Sales by Invoice Number</h1>
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
                        <form method="post" action="{{ route('search.sales') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-sm-2">
                                    <label for="TextInput" class="form-label">Invoice Number <span class="req">*</span></label>
                                    <input type="number" class="form-control form-control-md" name="invoice_number" placeholder="Invoice Number" required="required"/>
                                    @error('invoice_number')
                                    <small class="text-danger">{{ $errors->first('invoice_number') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <label for="TextInput" class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-submit btn-primary w-100">FETCH</button>
                                </div>
                            </div>
                            <div class="row mt-3">
                                @if (count($errors) > 0)
                                <div role="alert" class="text-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </form>
                        @if($sales)
                        <div class="mt-5">
                            <table id="dataTbl" class="table table-sm display dataTable table-hover table-striped"><thead><tr><th>Invoice Number</th><th>Customer Name</th><th>Contact Number</th><th>Address</th><th>Date</th><th>Invoice</th></tr></thead><tbody>
                            <tr>                                
                                <td>{{ $sales->id }}</td>
                                <td>{{ $sales->customer_name }}</td>
                                <td>{{ $sales->contact_number }}</td>
                                <td>{{ $sales->address }}</td>
                                <td>{{ date('d/M/Y', strtotime($sales->sold_date)) }}</td>
                                <td><a class='btn btn-link' href="/sales-invoice/{{ $sales->id }}" target="_blank"><i class="fa fa-file-o text-info"></i></a></td>      
                            </tr>
                            </tbody></table>
                        </div>
                        @endif
                    </div>
                </div> <!-- .Card End -->
            </div>
        </div> <!-- Row end  -->
    </div>
</div>
@endsection