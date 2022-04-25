@extends("base")

@section("content")
<!-- Body: Header -->
<div class="body-header d-flex py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="fs-4 mt-1 mb-0">Profit & Loss Report</h1>
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
                        <form method="post" action="{{ route('reports.pandl') }}">
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
                                <div class="col-sm-2">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-submit btn-primary w-100">FETCH</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> <!-- .Card End -->
                <div class="mt-5">
                    @if($inputs)
                    <div class="row">
                        <div class="col-sm-12 table-responsive">
                            <div class="card mb-4">
                                <div class="card-header py-3 bg-transparent border-bottom-0">
                                    <h6 class="card-title mb-0 pe-3 text-truncate">Profit and Loss summary Report between {{ $inputs[0] }} and {{ $inputs[1] }}</h6>
                                    <small>last update 10 seconds ago</small>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered"><thead><tr><th>Invoice No.</th><th>Product Name</th><th>Qty</th><th>Purchase Rate/Qty</th><th>Sales Rate/Qty</th><th>Purchase Total</th><th>Sales Total</th><th>Profit</th></tr></thead><tbody>
                                    @php $etot = 0; $itot = 0; $ptot = 0; @endphp
                                    @foreach($sales as $record)
                                        <tr>
                                            <td><a href="/sales-invoice/{{ $record->sales_id }}" target="_blank">{{ $record->sales_id }}</a></td>
                                            <td>{{ $record->name }}</td>
                                            <td>{{ $record->qty }}</td>
                                            <td>{{ $record->prate }}</td>
                                            <td>{{ $record->srate }}</td>
                                            <td class="text-right">{{ $record->expense }}</td>
                                            <td class="text-right">{{ $record->income }}</td>
                                            <td class="text-right">{{ number_format($record->income-$record->expense, 2) }}</td>
                                        </tr>
                                        {{ $etot += $record->expense }} {{ $itot += $record->income }} {{ $ptot += $record->income-$record->expense }}
                                    @endforeach
                                    <tr><td colspan="5" class="text-right fw-bold">Total</td><td class="text-right fw-bold">{{ number_format($etot, 2) }}</td><td class="text-right fw-bold">{{ number_format($itot, 2) }}</td><td class="text-right fw-bold">{{ number_format($ptot, 2) }}</td></tr>
                                    </tbody></table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div> <!-- Row end  -->
    </div>
</div>
@endsection