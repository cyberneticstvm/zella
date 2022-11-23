@extends("base")
@section("content")
<div class="body-header d-flex py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="fs-4 mt-1 mb-0">Notepad Register</h1>
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
                        <p class= "text-right my-3"><a href="/notepad/create/"><i class="fa fa-plus fa-lg text-success"></i></a></p>
                        <table id="dataTbl" class="table table-striped table-hover align-middle table-sm" style="width:100%">
                            <thead><tr><th>SL No.</th><th>Matter</th><th>Date</th><th>Edit</th><th>Remove</th></tr></thead><tbody>
                            @php $i = 0; @endphp
                            @foreach($notepads as $notepad)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $notepad->matter }}</td>
                                    <td>{{ $notepad->edate }}</td>
                                    <td><a class='btn btn-link' href="{{ route('notepad.edit', $notepad->id) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                                    <td>
                                        <form method="post" action="{{ route('notepad.delete', $notepad->id) }}">
                                            @csrf 
                                            @method("DELETE")
                                            <button type="submit" class="btn btn-link" onclick="javascript: return confirm('Are you sure want to delete this Record?');"><i class="fa fa-times text-danger"></i></button>
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