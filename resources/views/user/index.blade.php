@extends("base")

@section("content")
<!-- Body: Header -->
<div class="body-header d-flex py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="fs-4 mt-1 mb-0">User Register</h1>
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
                        <div class="text-right"><a href="/user/create/"><i class="fa fa-plus text-primary"></i></a></div>
                        <table id="dataTbl" class="table display table-sm dataTable table-striped table-hover align-middle" style="width:100%">
                        <thead><tr><th>SL No.</th><th>Name</th><th>Username</th><th>Email</th><th>Role</th><th>Edit</th><th>Remove</th></tr></thead><tbody>
                        @php $i = 0; @endphp
                        @foreach($users as $user)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                            @if(!empty($user->getRoleNames()))
                                @foreach($user->getRoleNames() as $v)
                                {{ $v }}
                                @endforeach
                            @endif
                            </td>
                            <td><a class='btn btn-link' href="{{ route('user.edit', $user->id) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                            <td>
                                <form method="post" action="{{ route('user.delete', $user->id) }}">
                                    @csrf 
                                    @method("DELETE")
                                    <button type="submit" class="btn btn-link" onclick="javascript: return confirm('Are you sure want to delete this User?');"><i class="fa fa-times text-danger"></i></button>
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