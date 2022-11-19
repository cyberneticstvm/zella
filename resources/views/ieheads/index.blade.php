@extends("base")
@section("content")
<div class="body-header d-flex py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="fs-4 mt-1 mb-0">Income Expense Heads Register</h1>
                <!--<small class="text-muted">You have 12 new messages and 7 new notifications.</small>-->
            </div>
        </div>
    </div>
</div>
<div class="body d-flex">
    <div class="container">        
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 border-0">
                    <div class="card-body">
                        <p class= "text-right my-3"><a href="/income-expense-heads/create/"><i class="fa fa-plus fa-lg text-success"></i></a></p>
                        <table id="dataTbl" class="table table-striped table-hover align-middle table-sm" style="width:100%">
                            <thead><tr><th>SL No.</th><th>Head Name</th><th>Type</th><th>Edit</th><th>Remove</th></tr></thead><tbody>
                            @php $i = 0; @endphp
                            @foreach($heads as $head)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $head->name }}</td>
                                    <td>{{ $head->type }}</td>
                                    <td><a class='btn btn-link' href="{{ route('income-expense-heads.edit', $head->id) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                                    <td>
                                        <form method="post" action="{{ route('income-expense-heads.delete', $head->id) }}">
                                            @csrf 
                                            @method("DELETE")
                                            <button type="submit" class="btn btn-link" onclick="javascript: return confirm('Are you sure want to delete this Head?');"><i class="fa fa-trash text-danger"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection