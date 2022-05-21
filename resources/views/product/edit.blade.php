@extends("base")

@section("content")
<!-- Body: Header -->
<div class="body-header d-flex py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="fs-4 mt-1 mb-0">Edit Product</h1>
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
                        <form method="post" action="{{ route('product.update', $product->id) }}">
                            @csrf
                            @method("PUT")
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="TextInput" class="form-label">Product Name <span class="req">*</span></label>
                                    <input type="text" class="form-control" placeholder="Product Name" value="{{ $product->name }}" required="required" name="name">
                                    @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-4">
                                    <label for="TextInput" class="form-label">Collection <span class="req">*</span></label>
                                    <select name='collection' class='form-control' required='required'>
                                        <option value=''>Select</option>
                                        @foreach($collections as $collection)
                                            <option value="{{ $collection->id }}" {{ ($collection->id == $product->collection) ? "selected='selected'" : '' }}>{{ $collection->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('collection')
                                    <small class="text-danger">{{ $errors->first('collection') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <label for="TextInput" class="form-label">SKU <span class="req">*</span></label>
                                    <input type="text" class="form-control" placeholder="SKU" value="{{ $product->sku }}" required="required" name="sku">
                                    @error('sku')
                                    <small class="text-danger">{{ $errors->first('sku') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <label for="TextInput" class="form-label">Size</label>
                                    <select name='size' class='form-control'>
                                        <option value=''>Select</option>
                                        @foreach($sizes as $size)
                                            <option value="{{ $size->id }}" {{ ($size->id == $product->size) ? "selected='selected'" : '' }}>{{ $size->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('size')
                                    <small class="text-danger">{{ $errors->first('size') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <label for="TextInput" class="form-label">Color</label>
                                    <select name='color' class='form-control'>
                                        <option value=''>Select</option>
                                        @foreach($colors as $color)
                                            <option value="{{ $color->id }}" {{ ($color->id == $product->color) ? "selected='selected'" : '' }}>{{ $color->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('color')
                                    <small class="text-danger">{{ $errors->first('color') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <label for="TextInput" class="form-label">Material</label>
                                    <select name='material' class='form-control'>
                                        <option value=''>Select</option>
                                        @foreach($materials as $material)
                                            <option value="{{ $material->id }}" {{ ($material->id == $product->material) ? "selected='selected'" : '' }}>{{ $material->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('material')
                                    <small class="text-danger">{{ $errors->first('material') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <label for="TextInput" class="form-label">Selling Price</label>
                                    <input type="number" class="form-control" placeholder="0.00" name="selling_price" value="{{ $product->selling_price }}">
                                    @error('selling_price')
                                    <small class="text-danger">{{ $errors->first('selling_price') }}</small>
                                    @enderror
                                </div>
                                <div class="col-sm-1">
                                    <label for="TextInput" class="form-label">VAT</label></br>
                                    <input type="checkbox" name="vat_applicable" value="1" class="form-check-input" {{ ($product->vat_applicable == 1) ? "checked='checked'" : '' }}>
                                    @error('vat_applicable')
                                    <small class="text-danger">{{ $errors->first('vat_applicable') }}</small>
                                    @enderror
                                </div>                            
                                <div class="col-sm-6">
                                    <label for="TextInput" class="form-label">Description</label>
                                    <textarea class="form-control" placeholder="Description" name="description">{{ $product->description }}</textarea>
                                    @error('description')
                                    <small class="text-danger">{{ $errors->first('description') }}</small>
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