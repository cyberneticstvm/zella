@extends("base")

@section("content")
<!-- Body: Header -->
<div class="body-header d-flex py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="fs-4 mt-1 mb-0">Search Stock Status by Product</h1>
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
                        <form method="post" action="{{ route('search.status') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-sm-4">
                                    <label for="TextInput" class="form-label">Product <span class="req">*</span></label> 
                                    <select class="form-control form-control-md select2 selProduct" name="product" required="required">
                                        <option value="">Select</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ ($inputs && $inputs[0] == $product->id) ? 'selected' : '' }}>{{ $product->name.' - '.$product->sku }}</option>
                                        @endforeach
                                    </select>
                                    @error('product')
                                    <small class="text-danger">{{ $errors->first('product') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <label for="TextInput" class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-submit btn-primary w-100">FETCH</button>
                                </div>
                            </div>
                            <div class="row mt-3">
                                @if (count($errors) > 0)
                                <div role="alert" class="text-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div> <!-- .Card End -->
            </div>
        </div> <!-- Row end  -->
        @if($inputs)
        <div class="row row-cols-xl-6 row-cols-lg-3 row-cols-md-3 row-cols-sm-2 row-cols-1 g-2 mb-2 row-deck">
            <div class="col-md-2">
                <div class="card">
                    <div class="card-header chart-color1 text-light border-bottom-0">
                        <span class="text-truncate">Qty Sold</span>
                    </div>
                    <div class="card-body">
                        <div class="fs-3 chart-text-color1">{{ $qty_sold }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-header chart-color2 text-light border-bottom-0">
                        <span class="text-truncate">Sales Return</span>
                    </div>
                    <div class="card-body">
                        <div class="fs-3 chart-text-color1">{{ $qty_sreturn }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-header chart-color3 text-light border-bottom-0">
                        <span class="text-truncate">Qty Purchase</span>
                    </div>
                    <div class="card-body">
                        <div class="fs-3 chart-text-color1">{{ $qty_purchase }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-header chart-color4 text-light border-bottom-0">
                        <span class="text-truncate">Purchase Return</span>
                    </div>
                    <div class="card-body">
                        <div class="fs-3 chart-text-color1">{{ $qty_preturn }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-header chart-color5 text-light border-bottom-0">
                        <span class="text-truncate">Stock in Hand</span>
                    </div>
                    <div class="card-body">
                        <div class="fs-3 chart-text-color1">{{ ($qty_purchase-$qty_preturn)-($qty_sold-$qty_sreturn) }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endif;
    </div>
</div>
@endsection