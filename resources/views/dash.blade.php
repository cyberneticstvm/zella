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
                            <div class="text-muted small">Total Revenue this Year</div>
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
                            <div class="text-muted small">Total Revenue Last Year</div>
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
    </div>
</div>
@endsection