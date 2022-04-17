@extends("base")

@section("content")
<!-- Body: Header -->
<div class="body-header d-flex py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="fs-4 mt-1 mb-0">Edit Purchase</h1>
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
                        <form method="post" action="{{ route('purchase.update', $purchase->id) }}">
                            @csrf
                            @method("PUT")
                            <div class="row g-3">
                                <div class="col-sm-4">
                                    <label for="TextInput" class="form-label">Supplier <span class="req">*</span></label>
                                    <select name='supplier' class='form-control select2' required='required'>
                                        <option value=''>Select</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ ($supplier->id == $purchase->supplier) ? 'selected' : ''}}>{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier')
                                    <small class="text-danger">{{ $errors->first('supplier') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <label for="TextInput" class="form-label">Invoice Number <span class="req">*</span></label>
                                    <input type="text" class="form-control" placeholder="Invoice Number" name="invoice_number" value="{{ $purchase->invoice_number }}">
                                    @error('invoice_number')
                                    <small class="text-danger">{{ $errors->first('invoice_number') }}</small>
                                    @enderror
                                </div>                            
                                <div class="col-sm-3">
                                    <label class="form-label">Order Date <span class="req">*</span></label>
                                    <fieldset class="form-icon-group left-icon position-relative">
                                        <input type="text" value="{{ ($purchase->order_date) ? date('d/M/Y', strtotime($purchase->order_date)) : '' }}" name="order_date" class="form-control form-control-md dtpicker" placeholder="dd/mm/yyyy">
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
                                    <label class="form-label">Delivery Date <span class="req">*</span></label>
                                    <fieldset class="form-icon-group left-icon position-relative">
                                        <input type="text" value="{{ ($purchase->delivery_date) ? date('d/M/Y', strtotime($purchase->order_date)) : '' }}" name="delivery_date" class="form-control form-control-md dtpicker" placeholder="dd/mm/yyyy">
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
                                <div class="col-sm-2">
                                    <label for="TextInput" class="form-label">Payment Mode <span class="req">*</span></label>
                                    <select class="form-control form-control-md" name="payment_mode" required="required">
                                        <option value="">Select</option>
                                        <option value="cash" {{ ($purchase->payment_mode == 'cash') ? 'selected' : '' }}>Cash</option>
                                        <option value="card"  {{ ($purchase->payment_mode == 'card') ? 'selected' : '' }}>Card</option>
                                    </select>
                                    @error('payment_mode')
                                    <small class="text-danger">{{ $errors->first('payment_mode') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <label for="TextInput" class="form-label">Purchase Notes </label>
                                    <input type="text" class="form-control form-control-md" name="purchase_note" placeholder="Purchase Notes" value="{{ $purchase->purchase_note }}" />
                                    @error('purchase_note')
                                    <small class="text-danger">{{ $errors->first('purchase_note') }}</small>
                                    @enderror
                                </div>                                
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-12">
                                    <h5 class="text-center">Product Details</h5>
                                    <table style="width:75%; margin:0 auto;" class="table table-bordered tblPurchase">
                                        <thead><tr><th width='50%'>Product</th><th width='10%'>Qty</th><th width='15%'>Price</th><th width='15%'>Total</th><th class="text-center" width='10%'><a href="javascript:void(0)"><i class="fa fa-plus text-primary addPurchaseRow"></i></a></th></tr></thead>
                                        <tbody>
                                        @php $c = 0; @endphp
                                        @foreach($purchase_details as $pdetails)
                                        @php $c++; @endphp
                                            <tr>
                                                <td>
                                                    <select class="form-control form-control-md select2 selProduct" name="product[]" required="required">
                                                        <option value="">Select</option>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}" {{ ($pdetails->product == $product->id) ? 'selected' : '' }}>{{ $product->name.' - '.$product->sku }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type="number" class="form-control text-right qty" placeholder="0" name="qty[]" value="{{ $pdetails->qty }}" required='required'></td>
                                                <td><input type="number" class="form-control text-right price" value="{{ $pdetails->price }}" placeholder="0.00" name="price[]" required='required'></td>
                                                <td><input type="number" class="form-control text-right total" value="{{ $pdetails->total }}"placeholder="0.00" name="total[]" required='required'></td>
                                                <td class="text-center">
                                                    @if($c > 1 && $pdetails->is_return == 0)
                                                    <a href='javascript:void(0)' onClick='$(this).parent().parent().remove()'><i class='fa fa-trash text-danger'></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr><td colspan="3" class="text-right">Other Expenses</td><td><input type="number" class="form-control text-right" placeholder="0.00" value="{{ $purchase->other_expense }}" name="other_expense"></td></tr>
                                        </tfoot>
                                    </table>
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