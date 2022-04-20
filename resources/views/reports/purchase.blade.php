@extends("base")

@section("content")
<!-- Body: Header -->
<div class="body-header d-flex py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="fs-4 mt-1 mb-0">Purchase Report</h1>
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
                        <form method="post" action="{{ route('reports.purchase') }}">
                            @csrf
                            <div class="row g-3">
                            <div class="col-sm-3">
                                    <label class="form-label">From Date <span class="req">*</span></label>
                                    <fieldset class="form-icon-group left-icon position-relative">
                                        <input type="text" value="{{ ($inputs) ? $inputs[0] : '' }}" name="from_date" class="form-control form-control-md dtpicker" placeholder="dd/mm/yyyy" required='required'>
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
                                        <input type="text" value="{{ ($inputs) ? $inputs[1] : '' }}" name="to_date" class="form-control form-control-md dtpicker" placeholder="dd/mm/yyyy" required='required'>
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
                                <div class="col-sm-3">
                                    <label for="TextInput" class="form-label">Supplier</label>
                                    <select name='supplier' class='form-control select2'>
                                        <option value=''>Select</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ ($inputs && $inputs[2] == $supplier->id) ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier')
                                    <small class="text-danger">{{ $errors->first('supplier') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <label for="TextInput" class="form-label">Product </label>
                                    <select name='product' class='form-control select2'>
                                        <option value=''>Select</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ ($inputs && $inputs[3] == $product->id) ? 'selected' : '' }}>{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('product')
                                    <small class="text-danger">{{ $errors->first('product') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-10"></div>
                                <div class="col-sm-2"><button type="submit" class="btn btn-fetch btn-primary w-100">FETCH</button></div>
                            </div>
                        </form>
                        <div class="mt-5">
                            @if($inputs)
                            <div class="row mb-3">
                                <div class="col-md-5"></div>
                                <div class="col-md-1 text-center">
                                    <form method="post" action="{{ route('purchase.pdf') }}" target="_blank">
                                        @csrf
                                        <input type="hidden" name="inputs" value="{{ implode(',', $inputs) }}" />
                                        <button class="btn btn-link" type="submit"><i class="fa fa-lg fa-file-pdf-o text-danger pdfDownload" data-bs-toggle="tooltip" data-bs-placement="top" title="Export to PDF" aria-hidden="true"></i></button>
                                    </form>
                                </div>
                                <div class="col-md-1 text-center">
                                    <form method="post" action="{{ route('purchase-export') }}" target="_blank">
                                        @csrf
                                        <input type="hidden" name="inputs" value="{{ implode(',', $inputs) }}" />
                                        <button class="btn btn-link" type="submit"><i class="fa fa-lg fa-file-excel-o text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Export to Excel" aria-hidden="true"></i></button>
                                    </form>
                                </div>
                                <div class="col-md-5"></div>
                            </div>
                            @endif
                            <table id="dataTbl" class="table table-sm display dataTable table-hover table-striped"><thead><tr><th>SL No.</th><th>Zella Invoice</th><th>Supplier Invoice</th><th>Supplier Name</th><th>Order Date</th><th>Delivery Date</th><th>Payment Mode</th><th>Invoice Total</th></tr></thead><tbody>
                            @php $c = 1; @endphp
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