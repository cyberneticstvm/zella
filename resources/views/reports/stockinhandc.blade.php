@extends("base")

@section("content")
<!-- Body: Header -->
<div class="body-header d-flex py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="fs-4 mt-1 mb-0">Stock in Hand (Collection)</h1>
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
                        <div class="mt-5">
                            <table id="dataTbl" class="table table-sm display dataTable table-hover table-striped"><thead><tr><th>SL No.</th><th>Collection</th><th>Stock in Hand</th></tr></thead><tbody>
                            @php $c = 1; @endphp
                            @foreach($collections as $collection)
                                @php 
                                $stockin = DB::table('purchase_details')->where('is_return', 0)->whereIn('product', function($q) use($collection){
                                    $q->select('id')->from('products')->where('collection', $collection->id);
                                })->sum('qty');
                                $stockout = DB::table('sales_details')->where('is_return', 0)->whereIn('product', function($q) use($collection){
                                    $q->select('id')->from('products')->where('collection', $collection->id);
                                })->sum('qty');
                                @endphp
                                @if(($stockin - $stockout) > 0)
                                    <tr>
                                        <td>{{ $c++ }}</td>
                                        <td>{{ $collection->name }}</td>
                                        <td>{{ $stockin - $stockout}}</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody></table>
                        </div>
                    </div>
                </div> <!-- .Card End -->
            </div>
        </div> <!-- Row end  -->
    </div>
</div>
@endsection