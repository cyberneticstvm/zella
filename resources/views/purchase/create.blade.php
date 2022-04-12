@extends("base")

@section("content")
<!-- Body: Header -->
<div class="body-header d-flex py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="fs-4 mt-1 mb-0">New Purchase</h1>
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
                        <form method="post" action="{{ route('purchase.save') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-sm-4">
                                    <label for="TextInput" class="form-label">Supplier <span class="req">*</span></label>
                                    <select name='supplier' class='form-control select2' required='required'>
                                        <option value=''>Select</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier')
                                    <small class="text-danger">{{ $errors->first('supplier') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <label for="TextInput" class="form-label">Invoice Number</label>
                                    <input type="text" class="form-control" placeholder="Invoice Number" name="invoice_number" value="{{ old('invoice_number') }}">
                                    @error('invoice_number')
                                    <small class="text-danger">{{ $errors->first('invoice_number') }}</small>
                                    @enderror
                                </div>                            
                                <div class="col-sm-3">
                                    <label class="form-label">Order Date<sup class="text-danger">*</sup></label>
                                    <fieldset class="form-icon-group left-icon position-relative">
                                        <input type="text" value="{{ old('order_date') }}" name="order_date" class="form-control form-control-md dtpicker" placeholder="dd/mm/yyyy">
                                        <div class="form-icon position-absolute">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
                                                <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                            </svg>
                                        </div>
                                    </fieldset>
                                    @error('order_date')
                                    <small class="text-danger">{{ $errors->first('order_date') }}</small>
                                    @enderror
                                </div>                                
                                <div class="col-sm-3">
                                    <label class="form-label">Delivery Date<sup class="text-danger">*</sup></label>
                                    <fieldset class="form-icon-group left-icon position-relative">
                                        <input type="text" value="{{ old('delivery_date') }}" name="delivery_date" class="form-control form-control-md dtpicker" placeholder="dd/mm/yyyy">
                                        <div class="form-icon position-absolute">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
                                                <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                            </svg>
                                        </div>
                                    </fieldset>
                                    @error('delivery_date')
                                    <small class="text-danger">{{ $errors->first('delivery_date') }}</small>
                                    @enderror
                                </div>                                
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-12">
                                    <h5 class="text-center">Product Details</h5>
                                    <table style="width:75%; margin:0 auto;" class="table table-bordered tblPurchase">
                                        <thead><tr><th width='50%'>Product</th><th width='10%'>Qty</th><th width='15%'>Price</th><th width='15%'>Total</th><th class="text-center" width='10%'><a href="javascript:void(0)"><i class="fa fa-plus text-primary addPurchaseRow"></i></a></th></tr></thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select class="form-control form-control-md select2 selProduct" name="product[]" required="required">
                                                        <option value="">Select</option>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}">{{ $product->name.' - '.$product->sku }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type="number" class="form-control text-right" placeholder="0" name="qty[]" required='required'></td>
                                                <td><input type="number" class="form-control text-right" placeholder="0.00" name="price[]" required='required'></td>
                                                <td><input type="number" class="form-control text-right" placeholder="0.00" name="total[]" required='required'></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-6"></div>
                                <div class="col-sm-2"><button type="button" class="btn btn-danger w-100" onClick="history.back()">CANCEL</button></div>
                                <div class="col-sm-2"><button type="reset" class="btn btn-warning w-100">RESET</button></div>
                                <div class="col-sm-2"><button type="submit" class="btn btn-submit btn-primary w-100">SAVE</button></div>
                            </div>
                        </form>
                    </div>
                </div> <!-- .Card End -->
            </div>
        </div> <!-- Row end  -->
    </div>
</div>
@endsection