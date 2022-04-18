@extends("base")

@section("content")
<!-- Body: Header -->
<div class="body-header d-flex py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="fs-4 mt-1 mb-0">Purchase Return</h1>
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
                        <form method="post" action="{{ route('preturn.fetch') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-sm-2">
                                    <label for="TextInput" class="form-label">Zella Invoice Number <span class="req">*</span></label>
                                    <input type="number" class="form-control form-control-md" name="invoice_number" placeholder="Invoice Number" value="{{ (!empty($purchase)) ? $purchase->id : old('invoice_number') }}" required="required" />
                                    @error('invoice_number')
                                    <small class="text-danger">{{ $errors->first('invoice_number') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <label for="TextInput" class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-submit btn-primary w-100">FETCH</button>
                                </div>                               
                            </div>
                        </form>
                        <div class="row mt-5">                            
                            @if(isset($purchases))
                            <div class="col-md-12">
                                <table class="table display table-sm table-striped table-hover align-middle" style="width:100%">
                                    <thead><tr><th>SL No</th><th>Product Name</th><th>Qty</th><th>Rate</th><th>Total</th><th>Return</th></tr></thead>
                                    <tbody>
                                        @php $c=1; @endphp
                                        @forelse($purchases as $row)
                                            <tr id="{{ $row->id }}">
                                                <td>{{ $c++ }}</td>
                                                <td>{{ $row->name }}</td>
                                                <td>{{ $row->qty }}</td>
                                                <td>{{ $row->price }}</td>
                                                <td>{{ $row->total }}</td>
                                                <td>
                                                    <form action="{{ route('purchase.updatereturn') }}">
                                                        <input type="checkbox" class="chkReturn" {{ ($row->is_return == 1) ? 'checked' : '' }}>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="6" class="text-center text-danger">No records found</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                        <div class="row mt-5">
                            <h1 class="fs-4 mb-3">Purchase Return Register</h1>
                            <table id="dataTbl" class="table display table-sm dataTable table-striped table-hover align-middle" style="width:100%">
                                <thead><tr><th>SL No.</th><th>Zella Invoice</th><th>Supplier Invoice</th><th>Supplier</th><th>Order Date</th><th>Delivery Date</th></tr></thead>
                                <tbody>
                                    @php $c = 1 @endphp
                                    @foreach($preturns as $preturn)
                                        <tr>
                                            <td>{{ $c++ }}</td>
                                            <td>{{ $preturn->id }}</td>
                                            <td>{{ $preturn->invoice_number }}</td>
                                            <td>{{ $preturn->name }}</td>
                                            <td>{{ $preturn->odate }}</td>
                                            <td>{{ $preturn->ddate }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- .Card End -->
            </div>
        </div> <!-- Row end  -->
    </div>
</div>
@endsection