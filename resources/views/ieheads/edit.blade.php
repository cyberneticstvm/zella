@extends("base")
@section("content")
<div class="body-header d-flex py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="fs-4 mt-1 mb-0">Edit Head</h1>
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
                        <form action="{{ route('income-expense-heads.update', $head->id) }}" method="post">
                            @csrf
                            @method("PUT")
                            <div class="row g-4">
                                <div class="col-sm-4">
                                    <label class="form-label">Head Name<sup class="text-danger">*</sup></label>
                                    <input type="text" value="{{ $head->name }}" name="name" class="form-control form-control-md" placeholder="Head Name">
                                    @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <label class="form-label">Type<sup class="text-danger">*</sup></label>
                                    <select class="form-control select2" name="type">
                                        <option value="I" {{ ($head->type == 'I') ? 'selected' : '' }}>Income</option>
                                        <option value="E" {{ ($head->type == 'E') ? 'selected' : '' }}>Expense</option>
                                    </select>
                                    @error('type')
                                    <small class="text-danger">{{ $errors->first('type') }}</small>
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