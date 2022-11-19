@extends("base")

@section("content")
<!-- Body: Header -->
<div class="body-header d-flex py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="fs-4 mt-1 mb-0">Dashboard</h1>
                <!--<small class="text-muted">You have 12 new messages and 7 new notifications.</small>-->
            </div>
        </div>
    </div>
</div>
<!-- Body: Body -->
<div class="body d-flex">
    <div class="container">        
        <div class="row">
            <div class="col-sm-3">
                <div class="card border-0 mb-3">
                    <div class="card-body d-flex align-items-start p-lg-4 p-3">
                        <div class="avatar rounded no-thumbnail">
                            <i class="fa fa-shopping-basket fa-lg"></i>
                        </div>
                        <div class="flex-fill ms-3">
                            <div class="fw-bold"><span class="h4 mb-0">{{ $sales_this_year }}</span><!--<span class="text-success ms-1">2.55% <i class="fa fa-caret-up"></i></span>--></div>
                            <div class="text-muted small">Total Orders this Year</div>
                            <div class="mt-3">
                                <label class="small d-flex justify-content-between">Today<span class="fw-bold">{{ $sales_today }}</span></label>
                                <div class="progress mt-1" style="height: 3px;">
                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="87" aria-valuemin="0" aria-valuemax="100" style="width: 87%;"></div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="small d-flex justify-content-between">This week<span class="fw-bold">{{ $sales_this_week }}</span></label>
                                <div class="progress mt-1" style="height: 3px;">
                                    <div class="progress-bar bg-info" role="progressbar" aria-valuenow="87" aria-valuemin="0" aria-valuemax="100" style="width: 87%;"></div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="small d-flex justify-content-between">This Month<span class="fw-bold">{{ $sales_this_month }}</span></label>
                                <div class="progress mt-1" style="height: 3px;">
                                    <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="87" aria-valuemin="0" aria-valuemax="100" style="width: 87%;"></div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="small d-flex justify-content-between">Last Month<span class="fw-bold">{{ $sales_last_month }}</span></label>
                                <div class="progress mt-1" style="height: 3px;">
                                    <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="44" aria-valuemin="0" aria-valuemax="100" style="width: 44%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card border-0 mb-3">
                    <div class="card-body d-flex align-items-start p-lg-4 p-3">
                        <div class="avatar rounded no-thumbnail">
                            <i class="fa fa-money fa-lg"></i>
                        </div>
                        <div class="flex-fill ms-3">
                            <div class="fw-bold"><span class="h4 mb-0">{{ number_format($revenue_this_year, 2) }}</span><!--<span class="text-success ms-1">2.55% <i class="fa fa-caret-up"></i></span>--></div>
                            <div class="text-muted small">Total Sales this Year</div>
                            <div class="mt-3">
                                <label class="small d-flex justify-content-between">Today<span class="fw-bold">{{ number_format($revenue_today, 2) }}</span></label>
                                <div class="progress mt-1" style="height: 3px;">
                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="87" aria-valuemin="0" aria-valuemax="100" style="width: 87%;"></div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="small d-flex justify-content-between">This week<span class="fw-bold">{{ number_format($revenue_this_week, 2) }}</span></label>
                                <div class="progress mt-1" style="height: 3px;">
                                    <div class="progress-bar bg-info" role="progressbar" aria-valuenow="87" aria-valuemin="0" aria-valuemax="100" style="width: 87%;"></div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="small d-flex justify-content-between">This Month<span class="fw-bold">{{ number_format($revenue_this_month, 2) }}</span></label>
                                <div class="progress mt-1" style="height: 3px;">
                                    <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="87" aria-valuemin="0" aria-valuemax="100" style="width: 87%;"></div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="small d-flex justify-content-between">Last Month<span class="fw-bold">{{ number_format($revenue_last_month, 2) }}</span></label>
                                <div class="progress mt-1" style="height: 3px;">
                                    <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="44" aria-valuemin="0" aria-valuemax="100" style="width: 44%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card border-0 mb-3">
                    <div class="card-body d-flex align-items-start p-lg-4 p-3">
                        <div class="avatar rounded no-thumbnail">
                            <i class="fa fa-money fa-lg"></i>
                        </div>
                        <div class="flex-fill ms-3">
                            <div class="fw-bold"><span class="h4 mb-0">{{ number_format($expense_this_year, 2) }}</span><!--<span class="text-success ms-1">2.55% <i class="fa fa-caret-up"></i></span>--></div>
                            <div class="text-muted small">Total Expenses this Year</div>
                            <div class="mt-3">
                                <label class="small d-flex justify-content-between">Today<span class="fw-bold">{{ number_format($expense_today, 2) }}</span></label>
                                <div class="progress mt-1" style="height: 3px;">
                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="87" aria-valuemin="0" aria-valuemax="100" style="width: 87%;"></div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="small d-flex justify-content-between">This week<span class="fw-bold">{{ number_format($expense_this_week, 2) }}</span></label>
                                <div class="progress mt-1" style="height: 3px;">
                                    <div class="progress-bar bg-info" role="progressbar" aria-valuenow="87" aria-valuemin="0" aria-valuemax="100" style="width: 87%;"></div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="small d-flex justify-content-between">This Month<span class="fw-bold">{{ number_format($expense_this_month, 2) }}</span></label>
                                <div class="progress mt-1" style="height: 3px;">
                                    <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="87" aria-valuemin="0" aria-valuemax="100" style="width: 87%;"></div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="small d-flex justify-content-between">Last Month<span class="fw-bold">{{ number_format($expense_last_month, 2) }}</span></label>
                                <div class="progress mt-1" style="height: 3px;">
                                    <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="44" aria-valuemin="0" aria-valuemax="100" style="width: 44%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card border-0 mb-3">
                    <div class="card-body d-flex align-items-start p-lg-4 p-3">
                        <div class="avatar rounded no-thumbnail">
                            <i class="fa fa-gift fa-lg"></i>
                        </div>
                        <div class="flex-fill ms-3">
                            <div class="fw-bold"><span class="h4 mb-0">{{ number_format($purchase_this_year, 2) }}</span><!--<span class="text-success ms-1">2.55% <i class="fa fa-caret-up"></i></span>--></div>
                            <div class="text-muted small">Total Purchases this Year</div>
                            <div class="mt-3">
                                <label class="small d-flex justify-content-between">Today<span class="fw-bold">{{ number_format($purchase_today, 2) }}</span></label>
                                <div class="progress mt-1" style="height: 3px;">
                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="87" aria-valuemin="0" aria-valuemax="100" style="width: 87%;"></div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="small d-flex justify-content-between">This week<span class="fw-bold">{{ number_format($purchase_this_week, 2) }}</span></label>
                                <div class="progress mt-1" style="height: 3px;">
                                    <div class="progress-bar bg-info" role="progressbar" aria-valuenow="87" aria-valuemin="0" aria-valuemax="100" style="width: 87%;"></div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="small d-flex justify-content-between">This Month<span class="fw-bold">{{ number_format($purchase_this_month, 2) }}</span></label>
                                <div class="progress mt-1" style="height: 3px;">
                                    <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="87" aria-valuemin="0" aria-valuemax="100" style="width: 87%;"></div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="small d-flex justify-content-between">Last Month<span class="fw-bold">{{ number_format($purchase_last_month, 2) }}</span></label>
                                <div class="progress mt-1" style="height: 3px;">
                                    <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="44" aria-valuemin="0" aria-valuemax="100" style="width: 44%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- Row end  -->
        <div class="row">
            <div class="col-sm-3">
                <div class="card border-0 mb-3">
                    <div class="card-body d-flex align-items-start p-lg-4 p-3">
                        <div class="avatar rounded no-thumbnail">
                            <i class="fa fa-shopping-basket fa-lg"></i>
                        </div>
                        <div class="flex-fill ms-3">
                            <div class="fw-bold"><span class="h4 mb-0">{{ $sales_last_year }}</span><!--<span class="text-success ms-1">2.55% <i class="fa fa-caret-up"></i></span>--></div>
                            <div class="text-muted small">Total Orders Last Year</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card border-0 mb-3">
                    <div class="card-body d-flex align-items-start p-lg-4 p-3">
                        <div class="avatar rounded no-thumbnail">
                            <i class="fa fa-money fa-lg"></i>
                        </div>
                        <div class="flex-fill ms-3">
                            <div class="fw-bold"><span class="h4 mb-0">{{ number_format($revenue_last_year, 2) }}</span><!--<span class="text-success ms-1">2.55% <i class="fa fa-caret-up"></i></span>--></div>
                            <div class="text-muted small">Total Sales Last Year</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card border-0 mb-3">
                    <div class="card-body d-flex align-items-start p-lg-4 p-3">
                        <div class="avatar rounded no-thumbnail">
                            <i class="fa fa-money fa-lg"></i>
                        </div>
                        <div class="flex-fill ms-3">
                            <div class="fw-bold"><span class="h4 mb-0">{{ number_format($expense_last_year, 2) }}</span><!--<span class="text-success ms-1">2.55% <i class="fa fa-caret-up"></i></span>--></div>
                            <div class="text-muted small">Total Expenses Last Year</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card border-0 mb-3">
                    <div class="card-body d-flex align-items-start p-lg-4 p-3">
                        <div class="avatar rounded no-thumbnail">
                            <i class="fa fa-gift fa-lg"></i>
                        </div>
                        <div class="flex-fill ms-3">
                            <div class="fw-bold"><span class="h4 mb-0">{{ number_format($purchase_last_year, 2) }}</span><!--<span class="text-success ms-1">2.55% <i class="fa fa-caret-up"></i></span>--></div>
                            <div class="text-muted small">Total Purchases Last Year</div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- Row end  -->
        <div class="row">
            <div class="col-12">
                <h5>Stock in Hand</h5>
                <!-- card: Calendar -->
                <div class="card mb-2">
                    <div class="card-body p-4">
                        <div class="mt-5">
                            <table id="dataTbl" class="table table-sm display dataTable table-hover table-striped"><thead><tr><th>SL No.</th><th>Product</th><th>Stock in Hand</th></tr></thead><tbody>
                            @php $c = 1; @endphp
                            @foreach($products as $product)
                            @php $stockin = DB::table('purchase_details')->where('product', $product->id)->where('is_return', 0)->sum('qty') @endphp
                            @php $stockout = DB::table('sales_details')->where('product', $product->id)->where('is_return', 0)->sum('qty') @endphp
                                @if(($stockin - $stockout) > 0)
                                <tr>
                                    <td>{{ $c++ }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $stockin - $stockout }}</td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody></table>
                        </div>
                    </div>
                </div> <!-- .Card End -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h5>Stock in Collections</h5>
                <!-- card: Calendar -->
                <div class="card mb-2">
                    <div class="card-body p-4">
                        <div class="mt-5">
                        <table id="dataTbl1" class="table table-sm display dataTable table-hover table-striped"><thead><tr><th>SL No.</th><th>Collection</th><th>Stock in Hand</th></tr></thead><tbody>
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
        </div>
    </div>
</div>

@endsection