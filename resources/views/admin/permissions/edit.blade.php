@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Edit Permission
    </div>

    <div class="card-body">
        <form id="permission_form" name="permission_form" action="{{ route("admin.permissions.update", [$permission->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">title*</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($permission) ? $permission->title : '') }}" required>
                
                
            </div>
            <div>
                <input type="submit" name="save" value="Save" class="btn btn-primary">
            </div>
        </form>


    </div>
</div>
@endsection