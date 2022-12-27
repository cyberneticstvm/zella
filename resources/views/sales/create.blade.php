@extends("base")

@section("content")
<!-- Body: Header -->
<div class="body-header d-flex py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="fs-4 mt-1 mb-0">New Sales</h1>
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
                        @if (count($errors) > 0)
                        <div role="alert" class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                        @endif
                        <form id="frm-sales" method="post" action="{{ route('sales.save') }}">
                            @csrf
                            <input type="hidden" id="is_dead_stock" name="is_dead_stock" value="0" />
                            <input type="hidden" id="card_fee" name="card_fee" value="{{ $settings->card_fee }}" />
                            <input type="hidden" id="vat" name="vat" value="{{ $settings->vat_percentage }}" />
                            <div class="row g-3">
                                <div class="col-sm-4">
                                    <label for="TextInput" class="form-label">Customer Name <span class="req">*</span></label>
                                    <input type="text" class="form-control" placeholder="Customer Name" name="customer_name" value="{{ old('customer_name') }}">
                                    @error('customer_name')
                                    <small class="text-danger">{{ $errors->first('customer_name') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <label for="TextInput" class="form-label">Contact Number <span class="req">*</span></label>
                                    <input type="text" class="form-control" placeholder="Contact Number" name="contact_number" value="{{ old('contact_number') }}">
                                    @error('contact_number')
                                    <small class="text-danger">{{ $errors->first('contact_number') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-5">
                                    <label for="TextInput" class="form-label">Customer Address</label>
                                    <input type="text" class="form-control" placeholder="Customer Address" name="address" value="{{ old('address') }}">
                                    @error('address')
                                    <small class="text-danger">{{ $errors->first('address') }}</small>
                                    @enderror
                                </div>                            
                                <div class="col-sm-3">
                                    <label class="form-label">Sales Date <span class="req">*</span></label>
                                    <fieldset class="form-icon-group left-icon position-relative">
                                        <input type="text" value="{{ date('d/M/Y') }}" name="sold_date" class="form-control form-control-md dtpicker" placeholder="dd/mm/yyyy">
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
                                
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-12 table-responsive">
                                    <h5 class="text-center">Product Details</h5>
                                    <table id="sTbl" class="table table-bordered tblSales">
                                        <thead><tr><th width="10%">Type</th><th width="25%">Old Product</th><th width="10%">Old Price</th><th width="25%">New Product</th><th width="10%">Qty</th><th width="10%">Price</th><th width="20%">Total</th><th class="text-center"><a href="javascript:void(0)"><i class="fa fa-plus text-primary addSalesRow"></i></a></th></tr></thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select class="form-control form-control-md select2 sType" name="type[]">
                                                        <option value="new">New</option>
                                                        <option value="return">Return</option>
                                                        <option value="replacement">Replacement</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control form-control-md select2 selOldProduct" name="old_product[]">
                                                        <option value="">Select</option>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}">{{ $product->name.' - '.$product->sku }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type='number' name='old_product_price[]' class='form-control oldprice' readonly /></td>
                                                <td>
                                                    <select class="form-control form-control-md select2 selProduct" name="product[]">
                                                        <option value="">Select</option>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}">{{ $product->name.' - '.$product->sku }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>                                                
                                                <td><input type="number" class="form-control text-right qty" step='any' placeholder="0" name="qty[]" required></td>
                                                <td><input type="number" class="form-control text-right price" step='any' placeholder="0.00" name="price[]"></td>
                                                <td><input type="number" class="form-control text-right total" step='any' placeholder="0.00" name="total[]"></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr><td colspan="6" class="text-right">Sub Total</td><td><input type="number" class="form-control text-right stot" placeholder="0.00"></td></tr>
                                            <tr><td colspan="6" class="text-right">Old Product Total</td><td><input type="number" class="form-control text-right old_pdct_tot" placeholder="0.00" step="any" name="old_product_total"></td></tr>
                                            <tr><td colspan="6" class="text-right">Discount</td><td><input type="number" class="form-control text-right discount" placeholder="0.00" step="any" name="discount"></td></tr>                                            
                                            <tr><td colspan="6" class="text-right">Grand Total</td><td class="text-success text-right fw-bold"><input type="number" step="any" class="form-control text-right gtot" placeholder="0.00" name="order_total"></td></tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="row g-3 mt-3">
                                <div class="col-sm-2">
                                    <label for="TextInput" class="form-label">Payment Mode <span class="req">*</span></label>
                                    <select class="form-control form-control-md payment_mode" name="payment_mode" required="required">
                                        <option value="">Select</option>
                                        <option value="cash">Cash</option>
                                        <option value="card">Card</option>
                                        <option value="candc">Cash & Card</option>
                                    </select>
                                    @error('payment_mode')
                                    <small class="text-danger">{{ $errors->first('payment_mode') }}</small>
                                    @enderror
                                </div>                                
                                <div class="col-sm-2">
                                    <label for="TextInput" class="form-label">Cash Collected</label>
                                    <input type="text" class="form-control form-control-md" name="cash_collected" placeholder="0.00"/>
                                    @error('cash_collected')
                                    <small class="text-danger">{{ $errors->first('cash_collected') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <label for="TextInput" class="form-label">Card Collected</label>
                                    <input type="text" class="form-control form-control-md" name="card_collected" placeholder="0.00"/>
                                    @error('card_collected')
                                    <small class="text-danger">{{ $errors->first('card_collected') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <label for="TextInput" class="form-label">Payment Status <span class="req">*</span></label>
                                    <select class="form-control form-control-md" name="payment_status" required="required">
                                        <option value="">Select</option>
                                        <option value="paid">Paid</option>
                                        <option value="notpaid">Not Paid</option>
                                    </select>
                                    @error('payment_status')
                                    <small class="text-danger">{{ $errors->first('payment_status') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-4">
                                    <label for="TextInput" class="form-label">Sales Note </label>
                                    <input type="text" class="form-control form-control-md" name="sales_note" placeholder="Sales Notes"/>
                                    @error('sales_note')
                                    <small class="text-danger">{{ $errors->first('sales_note') }}</small>
                                    @enderror
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
                        <h5 class="text-center">Sales Register</h5>
                        <table id="dataTbl" class="table display table-sm dataTable table-striped table-hover align-middle" style="width:100%">
                        <thead><tr><th>SL No.</th><th>Invoice Number</th><th>Customer Name</th><th>Contact Number</th><th>Address</th><th>Sold Date</th><th>Payment Status</th><th>Invoice</th><th>Edit</th><th>Remove</th></tr></thead><tbody>
                        @php $i = 0; @endphp
                        @foreach($sales as $sale)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $sale->id }}</td>
                            <td>{{ $sale->customer_name }}</td>
                            <td>{{ $sale->contact_number }}</td>
                            <td>{{ $sale->address }}</td>
                            <td>{{ date('d/M/Y', strtotime($sale->sold_date)) }}</td>
                            <td>{{ $sale->payment_status }}</td>
                            <td><a class='btn btn-link' href="/sales-invoice/{{ $sale->id }}" target="_blank"><i class="fa fa-file-o text-info"></i></a></td>
                            <td><a class='btn btn-link' href="{{ route('sales.edit', $sale->id) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                            <td>
                                <form method="post" action="{{ route('sales.delete', $sale->id) }}">
                                    @csrf 
                                    @method("DELETE")
                                    <button type="submit" class="btn btn-link" onclick="javascript: return confirm('Are you sure want to delete this Sale Record?');"><i class="fa fa-trash text-danger"></i></button>
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