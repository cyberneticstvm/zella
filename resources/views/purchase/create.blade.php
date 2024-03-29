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
                                    <label for="TextInput" class="form-label">Invoice Number <span class="req">*</span></label>
                                    <input type="text" class="form-control" placeholder="Invoice Number" name="invoice_number" value="{{ old('invoice_number') }}">
                                    @error('invoice_number')
                                    <small class="text-danger">{{ $errors->first('invoice_number') }}</small>
                                    @enderror
                                </div>                            
                                <div class="col-sm-3">
                                    <label class="form-label">Order Date <span class="req">*</span></label>
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
                                    <label class="form-label">Delivery Date <span class="req">*</span></label>
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
                                <div class="col-sm-2">
                                    <label for="TextInput" class="form-label">Payment Mode <span class="req">*</span></label>
                                    <select class="form-control form-control-md" name="payment_mode" required="required">
                                        <option value="">Select</option>
                                        <option value="cash">Cash</option>
                                        <option value="card">Card</option>
                                    </select>
                                    @error('payment_mode')
                                    <small class="text-danger">{{ $errors->first('payment_mode') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <label for="TextInput" class="form-label">Purchase Notes </label>
                                    <input type="text" class="form-control form-control-md" name="purchase_note" placeholder="Purchase Notes"/>
                                    @error('purchase_note')
                                    <small class="text-danger">{{ $errors->first('purchase_note') }}</small>
                                    @enderror
                                </div>                                
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-12 table-responsive">
                                    <h5 class="text-center">Product Details</h5>
                                    <table style="width:100%; margin:0 auto;" class="table table-bordered tblPurchase">
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
                                                <td><input type="number" step='any' class="form-control text-right qty" placeholder="0" name="qty[]" required='required'></td>
                                                <td><input type="number" step='any' class="form-control text-right price" placeholder="0.00" name="price[]" required='required'></td>
                                                <td><input type="number" step='any' class="form-control text-right total" placeholder="0.00" name="total[]" required='required'></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr><td colspan="3" class="text-right">Sub Total</td><td><input type="number" class="form-control text-right stot" name="purchase_total" placeholder="0.00" readonly="true"></td></tr>
                                            <tr><td colspan="3" class="text-right">Other Expenses</td><td><input type="number" class="form-control text-right" step='any' placeholder="0.00" name="other_expense"></td></tr>
                                            <tr><td colspan="3" class="text-right">Payment Status</td><td>
                                                <select class="form-control form-control-md" name="payment_status" required="required">
                                                    <option value="">Select</option>
                                                    <option value="paid">Paid</option>
                                                    <option value="notpaid">Not Paid</option>
                                                </select>
                                            </td></tr>
                                        </tfoot>
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
                <!-- card: Calendar -->
                <div class="card mb-2">
                    <div class="card-body p-4">
                        <h5 class="text-center">Purchase Register</h5>
                        <table id="dataTbl" class="table display table-sm dataTable table-striped table-hover align-middle" style="width:100%">
                        <thead><tr><th>SL No.</th><th>Zella Invoice</th><th>Supplier Name</th><th>Supplier Invoice</th><th>Order Date</th><th>Delivery Date</th><th>Invoice</th><th>Edit</th><th>Remove</th></tr></thead><tbody>
                        @php $i = 0; @endphp
                        @foreach($purchases as $purchase)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $purchase->id }}</td>
                            <td>{{ $purchase->name }}</td>
                            <td>{{ $purchase->invoice_number }}</td>
                            <td>{{ $purchase->odate }}</td>
                            <td>{{ $purchase->ddate }}</td>
                            <td class="text-center"><a class='btn btn-link' href="/purchase-invoice/{{ $purchase->id }}" target="_blank"><i class="fa fa-file-o text-info"></i></a></td>
                            <td><a class='btn btn-link' href="{{ route('purchase.edit', $purchase->id) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                            <td>
                                <form method="post" action="{{ route('purchase.delete', $purchase->id) }}">
                                    @csrf 
                                    @method("DELETE")
                                    <button type="submit" class="btn btn-link" onclick="javascript: return confirm('Are you sure want to delete this Purchase Record?');"><i class="fa fa-trash text-danger"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        </tbody></table>
                    </div>
                </div> <!-- .Card End -->
            </div>
        </div> <!-- Row end  -->
    </div>
</div>
@endsection