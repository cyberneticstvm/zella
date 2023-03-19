@extends("base")
@section("content")
<div class="body-header d-flex py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="fs-4 mt-1 mb-0">Daybook Consolidated on {{ date('d/M/Y') }}</h1>
                <!--<small class="text-muted">You have 12 new messages and 7 new notifications.</small>-->
            </div>
        </div>
    </div>
</div>
<div class="body d-flex">
    <div class="container">        
        <div class="row g-4">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-sm dataTable table-striped table-hover align-middle">
                            <thead><tr><th>SL No.</th><th>Particulars</th><th class="text-end">Total</th></tr></thead><tbody>
                            <tr>
                                <td>1</td><td>Cash Sales</td><td class="text-end">{{ number_format($sales_cash, 2) }}</td>
                            </tr>
                            <tr>
                                <td>2</td><td>Card Sales</td><td class="text-end">{{ number_format($sales_card, 2) }}</td>
                            </tr>
                            <tr>
                                <td>2</td><td>Cash and Card Sales</td><td class="text-end">{{ number_format($sales_candc, 2) }}</td>
                            </tr>
                            <tr>
                                <td>3</td><td>Income from other sources</td><td class="text-end">{{ number_format($incomes, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-end fw-bold">Total</td><td class="text-end fw-bold">{{ number_format($sales_cash+$sales_card+$sales_candc+$incomes, 2) }}</td>
                            </tr>
                            <tr>
                                <td>1</td><td>Purchase Total</td><td class="text-end">{{ number_format($purchases, 2) }}</td>
                            </tr>
                            <tr>
                                <td>2</td><td>Other Expenses</td><td class="text-end">{{ number_format($expenses, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-end fw-bold">Total</td><td class="text-end fw-bold">{{ number_format($purchases+$expenses, 2) }}</td>
                            </tr>      
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- .row end -->
    </div>
</div>
@endsection