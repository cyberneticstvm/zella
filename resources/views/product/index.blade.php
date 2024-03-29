@extends("base")

@section("content")
<!-- Body: Header -->
<div class="body-header d-flex py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="fs-4 mt-1 mb-0">Product Register</h1>
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
                        <a href="/product/download/pdf/" target="_blank"><i class="fa fa-lg fa-file-pdf-o text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Export to PDF" aria-hidden="true"></i></a>&nbsp;
                        <a href="/product/download/excel/" target="_blank"><i class="fa fa-lg fa-file-excel-o text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Export to Excel" aria-hidden="true"></i></a>&nbsp;
                        <a href="/product/download/barcodes/" target="_blank"><i class="fa fa-lg fa-barcode text-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Print Barcodes" aria-hidden="true"></i></a>
                        <div class="text-right"><a href="/product/create/"><i class="fa fa-plus text-primary"></i></a></div>
                        <table id="dataTbl" class="table display table-sm dataTable table-striped table-hover align-middle" style="width:100%">
                        <thead><tr><th>SL No.</th><th>Product Name</th><th>Collection</th><th>SKU</th><th>Purchase Price</th><th>Selling Price</th><th>Description</th><th>VAT</th><th>Barcode</th><th>Edit</th><th>Remove</th></tr></thead><tbody>
                        @php $i = 0; @endphp
                        @foreach($products as $product)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->collection_name }}</td>
                            <td>{{ $product->sku }}</td>
                            <td class="text-right">{{ $product->purchase_price }}</td>
                            <td class="text-right">{{ $product->selling_price }}</td>
                            <td>{{ $product->description }}</td>
                            <td>
                                @if($product->vat_applicable == 1)
                                    <i class="fa fa-check text-success"></i>
                                @else
                                    <i class="fa fa-close text-danger"></i>
                                @endif
                            </td>
                            <td class="text-center"><a href="{{ route('barcode.pdf', $product->id) }}" target="_blank"><i class="fa fa-barcode text-dark"></i></a></td>
                            <td><a class='btn btn-link' href="{{ route('product.edit', $product->id) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                            <td>
                                <form method="post" action="{{ route('product.delete', $product->id) }}">
                                    @csrf 
                                    @method("DELETE")
                                    <button type="submit" class="btn btn-link" onclick="javascript: return confirm('Are you sure want to delete this Product?');"><i class="fa fa-times text-danger"></i></button>
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