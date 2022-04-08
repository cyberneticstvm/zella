@extends("base")

@section("content")
<!-- Body: Header -->
<div class="body-header d-flex py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="fs-4 mt-1 mb-0">Edit Supplier</h1>
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
                        <form method="post" action="{{ route('supplier.update', $supplier->id) }}">
                            @csrf
                            @method("PUT")
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="TextInput" class="form-label">Supplier Name <span class="req">*</span></label>
                                    <input type="text" class="form-control" placeholder="Full Name" value="{{ $supplier->name }}" required="required" name="name">
                                    @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <label for="TextInput" class="form-label">Contact Number</label>
                                    <input type="text" class="form-control" placeholder="Contact Number" name="contact_number" value="{{ $supplier->contact_number }}">
                                    @error('contact_number')
                                    <small class="text-danger">{{ $errors->first('contact_number') }}</small>
                                    @enderror
                                </div>                            
                                <div class="col-sm-3">
                                    <label for="TextInput" class="form-label">Email </label>
                                    <input type="email" class="form-control" placeholder="Email" name="email" value="{{ $supplier->email }}">
                                    @error('email')
                                    <small class="text-danger">{{ $errors->first('email') }}</small>
                                    @enderror
                                </div>                                
                                <div class="col-sm-6">
                                    <label for="TextInput" class="form-label">Address <span class="req">*</span></label>
                                    <textarea name='address' class='form-control' placeholder="Address">{{ $supplier->address }}</textarea>
                                    @error('address')
                                    <small class="text-danger">{{ $errors->first('address') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-6"></div>
                                <div class="col-sm-2"><button type="button" class="btn btn-danger w-100" onClick="history.back()">CANCEL</button></div>
                                <div class="col-sm-2"><button type="reset" class="btn btn-warning w-100">RESET</button></div>
                                <div class="col-sm-2"><button type="submit" class="btn btn-submit btn-primary w-100">UPDATE</button></div>
                            </div>
                        </form>
                    </div>
                </div> <!-- .Card End -->
            </div>
        </div> <!-- Row end  -->
    </div>
</div>
@endsection