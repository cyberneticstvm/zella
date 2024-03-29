@extends("base")
@section("content")
<div class="body-header d-flex py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="fs-4 mt-1 mb-0">Edit Expense</h1>
                <!--<small class="text-muted">You have 12 new messages and 7 new notifications.</small>-->
            </div>
        </div>
    </div>
</div>
<div class="body d-flex">
    <div class="container">        
        <div class="row g-4">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('expense.update', $expense->id) }}" method="post">
                            @csrf
                            @method("PUT")
                            <div class="row g-4">
                                <div class="col-sm-3">
                                    <label class="form-label">Expense Date</label>
                                    <fieldset class="form-icon-group left-icon position-relative">
                                        <input type="text" value="{{ date('d/M/Y', strtotime($expense->date)) }}" name="date" class="form-control form-control-md dtpicker" placeholder="dd/mm/yyyy">
                                        <div class="form-icon position-absolute">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
                                                <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                            </svg>
                                        </div>
                                    </fieldset>
                                    @error('date')
                                    <small class="text-danger">{{ $errors->first('date') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <label class="form-label">Head<sup class="text-danger">*</sup></label>
                                    <select class="form-control form-control-md show-tick ms select2" data-placeholder="Select" name="head">
                                    <option value="">Select</option>
                                    @foreach($heads as $head)
                                        <option value="{{ $head->id }}" {{ $expense->head == $head->id ? 'selected' : '' }}>{{ $head->name }}</option>
                                    @endforeach
                                    </select>
                                    @error('head')
                                    <small class="text-danger">{{ $errors->first('head') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-4">
                                    <label class="form-label">Description</label>
                                    <input type="text" value="{{ $expense->description }}" name="description" class="form-control form-control-md" placeholder="Description">
                                    @error('description')
                                    <small class="text-danger">{{ $errors->first('description') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <label class="form-label">Amount<sup class="text-danger">*</sup></label>
                                    <input type="number" value="{{ $expense->amount }}" name="amount" step="any" class="form-control form-control-md" placeholder="0.00">
                                    @error('amount')
                                    <small class="text-danger">{{ $errors->first('amount') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-12 text-right">
                                    <button type="button" onClick="history.back()"  class="btn btn-danger">Cancel</button>
                                    <button type="reset" class="btn btn-warning">Reset</button>
                                    <button type="submit" class="btn btn-primary btn-submit">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- .row end -->
    </div>
</div>
@endsection