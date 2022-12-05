@extends("base")

@section("content")
<!-- Body: Header -->
<div class="body-header d-flex py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="fs-4 mt-1 mb-0">consolidated Report</h1>
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
                        <form method="post" action="{{ route('reports.consolidated') }}">
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
                                    <label for="TextInput" class="form-label">Head </label>
                                    <select class="form-control form-control-md" name="head">
                                        <option value="1" {{ ($inputs && $inputs[2] == 1) ? 'selected' : '' }}>Purchase</option>
                                        <option value="2" {{ ($inputs && $inputs[2] == 2) ? 'selected' : '' }}>Sales</option>
                                        <option value="3" {{ ($inputs && $inputs[2] == 3) ? 'selected' : '' }}>Income from Heads</option>
                                        <option value="4" {{ ($inputs && $inputs[2] == 4) ? 'selected' : '' }}>Expense from Heads</option>
                                    </select>
                                    @error('head')
                                    <small class="text-danger">{{ $errors->first('head') }}</small>
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
                            <!--<div class="mb-3 text-right">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Export
                                    </button>
                                    <div class="dropdown-menu text-muted border-0 shadow" style="max-width: 200px;">
                                        <form class="export" method="post" action="{{ route('expense.pdf') }}" target="_blank">
                                            @csrf
                                            <input type="hidden" name="inputs" value="{{ implode(',', $inputs) }}" />
                                            <button class="btn btn-link" type="submit"><i class="fa fa-file-pdf-o text-danger pdfDownload" data-bs-toggle="tooltip" data-bs-placement="top" title="Export to PDF" aria-hidden="true"> PDF</i></button>
                                        </form>
                                        <div class="dropdown-divider"></div>
                                        <form class="export" method="post" action="{{ route('expense-export') }}" target="_blank">
                                            @csrf
                                            <input type="hidden" name="inputs" value="{{ implode(',', $inputs) }}" />
                                            <button class="btn btn-link" type="submit"><i class="fa fa-file-excel-o text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Export to Excel" aria-hidden="true"> Excel</i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>-->
                            @endif
                            <table id="dataTbl" class="table table-sm display dataTable table-hover table-striped"><thead><tr><th>SL No.</th><th>Date</th><th>Amount</th></tr></thead><tbody>
                            @php $c = 1; $tot = 0; $gtot = 0; @endphp
                            @forelse($records as $key => $record)
                                <tr>
                                    <td>{{ $c++ }}</td>
                                    <td>{{ $record->date }}</td>
                                    <td class="text-end">{{ number_format($record->total, 2) }}</td>
                                </tr>
                                @php $tot += $record->total; @endphp
                            @empty
                            @endforelse                            
                            </tbody>
                            <tfoot><tr><td></td><td class="text-end fw-bold">Total</td><td class="text-end fw-bold">{{ number_format($tot, 2) }}</td></tr></tfoot>
                            </table>
                            <!--<div class="text-end fw-bold mt-3">Total: {{ number_format($tot, 2) }}</div>-->
                        </div>
                    </div>
                </div> <!-- .Card End -->
            </div>
        </div> <!-- Row end  -->
    </div>
</div>
@endsection