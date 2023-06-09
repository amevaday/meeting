@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
       Add Permission
    </div>

    <div class="card-body">
        <form id="permission_form" name="permission_form" action="{{ route("admin.permissions.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Title*</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($permission) ? $permission->title : '') }}" required>
               
               
            </div>
            <div>
                <input type="submit" name="save" value="Save" class="btn btn-primary">
            </div>
        </form>


    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/permission_create.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
@endsection