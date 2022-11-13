@extends("base")

@section("content")
<!-- Body: Header -->
<div class="body-header d-flex py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="fs-4 mt-1 mb-0">Expense Register</h1>
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
                        <div class="text-right"><a href="/expense/create/"><i class="fa fa-plus text-primary"></i></a></div>
                        <table id="dataTbl" class="table display table-sm dataTable table-striped table-hover align-middle" style="width:100%">
                        <thead><tr><th>SL No.</th><th>Expense Date</th><th>Description</th><th>Amount</th><th>Head</th><th>Edit</th><th>Remove</th></tr></thead><tbody>
                        @php $i = 0; @endphp
                        @foreach($expenses as $expense)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ date('d/M/Y', strtotime($expense->expense_date)) }}</td>
                            <td>{{ $expense->description }}</td>
                            <td>{{ $expense->amount }}</td>
                            <td>{{ $expense->department }}</td>
                            <td><a class='btn btn-link' href="{{ route('expense.edit', $expense->id) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                            <td>
                                <form method="post" action="{{ route('expense.delete', $expense->id) }}">
                                    @csrf 
                                    @method("DELETE")
                                    <button type="submit" class="btn btn-link" onclick="javascript: return confirm('Are you sure want to delete this Record?');"><i class="fa fa-times text-danger"></i></button>
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