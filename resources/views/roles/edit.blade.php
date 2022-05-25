@extends("base")

@section("content")
<!-- Body: Header -->
<div class="body-header d-flex py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="fs-4 mt-1 mb-0">Update Role</h1>
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
                        <form method="post" action="{{ route('role.update', $role->id) }}">
                            @csrf
                            @method("PUT")
                            <div class="row g-3">
                                <div class="col-sm-12">
                                    <label for="TextInput" class="form-label">Role Name <span class="req">*</span></label>
                                    {!! Form::text('name', $role->name, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                    @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @enderror
                                </div>                            
                                <div class="col-sm-12">
                                    <label for="TextInput" class="form-label">Permissions <span class="req">*</span></label><br />
                                    @foreach($permission as $value)
                                        <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                        {{ $value->name }}</label>
                                    <br/>
                                    @endforeach
                                    @error('password')
                                    <small class="text-danger">{{ $errors->first('password') }}</small>
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