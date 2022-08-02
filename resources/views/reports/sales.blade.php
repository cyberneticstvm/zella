@extends("base")

@section("content")
<!-- Body: Header -->
<div class="body-header d-flex py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="fs-4 mt-1 mb-0">Sales Report</h1>
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
                        <form method="post" action="{{ route('reports.sales') }}">
                            @csrf
                            <div class="row g-3">
                            <div class="col-sm-3">
                                    <label class="form-label">From Date <span class="req">*</span></label>
                                    <fieldset class="form-icon-group left-icon position-relative">
                                        <input type="text" value="{{ ($inputs) ? $inputs[0] : date('d/M/Y') }}" name="from_date" class="form-control form-control-md dtpicker" placeholder="dd/mm/yyyy" required='required'>
                                        <div class="form-icon position-absolute">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
                                                <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                            </svg>
                                        </div>
                                    </fieldset>
                                    @error('from_date')
                                    <small class="text-danger">{{ $errors->first('from_date') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <label class="form-label">To Date <span class="req">*</span></label>
                                    <fieldset class="form-icon-group left-icon position-relative">
                                        <input type="text" value="{{ ($inputs) ? $inputs[1] : date('d/M/Y') }}" name="to_date" class="form-control form-control-md dtpicker" placeholder="dd/mm/yyyy" required='required'>
                                        <div class="form-icon position-absolute">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
                                                <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                            </svg>
                                        </div>
                                    </fieldset>
                                    @error('to_date')
                                    <small class="text-danger">{{ $errors->first('to_date') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <label for="TextInput" class="form-label">Product </label>
                                    <select name='product' class='form-control select2'>
                                        <option value=''>Select</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ ($inputs && $inputs[2] == $product->id) ? 'selected' : '' }}>{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('product')
                                    <small class="text-danger">{{ $errors->first('product') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <label for="TextInput" class="form-label">Payment Mode </label>
                                    <select class="form-control form-control-md" name="payment_mode">
                                        <option value="">Select</option>
                                        <option value="cash" {{ ($inputs && $inputs[3] == 'cash') ? 'selected' : '' }}>Cash</option>
                                        <option value="card" {{ ($inputs && $inputs[3] == 'card') ? 'selected' : '' }}>Card</option>
                                    </select>
                                    @error('payment_mode')
                                    <small class="text-danger">{{ $errors->first('payment_mode') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <label for="TextInput" class="form-label">Payment Status </label>
                                    <select class="form-control form-control-md" name="payment_status">
                                        <option value="">Select</option>
                                        <option value="paid" {{ ($inputs && $inputs[4] == 'paid') ? 'selected' : '' }}>Paid</option>
                                        <option value="notpaid" {{ ($inputs && $inputs[4] == 'notpaid') ? 'selected' : '' }}>Not Paid</option>
                                    </select>
                                    @error('payment_mode')
                                    <small class="text-danger">{{ $errors->first('payment_mode') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-10"></div>
                                <div class="col-sm-2"><button type="submit" class="btn btn-submit btn-primary w-100">FETCH</button></div>
                            </div>
                        </form>
                        <div class="mt-5">
                            @if($inputs)
                            <div class="mb-3 text-right">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Export
                                    </button>
                                    <div class="dropdown-menu text-muted border-0 shadow" style="max-width: 200px;">
                                        <form class="export" method="post" action="{{ route('sales.pdf') }}" target="_blank">
                                            @csrf
                                            <input type="hidden" name="inputs" value="{{ implode(',', $inputs) }}" />
                                            <button class="btn btn-link" type="submit"><i class="fa fa-file-pdf-o text-danger pdfDownload" data-bs-toggle="tooltip" data-bs-placement="top" title="Export to PDF" aria-hidden="true"> PDF</i></button>
                                        </form>
                                        <div class="dropdown-divider"></div>
                                        <form class="export" method="post" action="{{ route('sales-export') }}" target="_blank">
                                            @csrf
                                            <input type="hidden" name="inputs" value="{{ implode(',', $inputs) }}" />
                                            <button class="btn btn-link" type="submit"><i class="fa fa-file-excel-o text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Export to Excel" aria-hidden="true"> Excel</i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <table id="dataTbl" class="table table-sm display dataTable table-hover table-striped"><thead><tr><th>SL No.</th><th>Invoice Number</th><th>Date</th><th>Payment Mode</th><th>Payment Status</th><th>Customer Name</th><th>Contact Number</th><th>Address</th><th>Invoice Total</th></tr></thead><tbody>
                            @php $c = 1; @endphp
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