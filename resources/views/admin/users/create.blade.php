@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
       Add User
    </div>
    <div class="card-body">
            <form id="create-user-form" name="create-user-form" method="POST" action="{{ route("admin.users.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($user) ? $user->name : '') }}" >
               
            </div>
            <div class="form-group">
                <label for="email">Email*</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', isset($user) ? $user->email : '') }}">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="number" id="phone" name="phone" class="form-control"
                    value="">
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Gender</label>
                <div class="col-sm-9">
                    <input type="radio" name="gender" value="Male"> Male
                    <input type="radio" name="gender" value="Female"> Female
                </div>
            </div>
            <div class="form-group">
                <label for="address">Address*</label>
                <textarea type="text" id="address" name="address" class="form-control" value="{{ old('address', isset($user) ? $user->address : '') }}" ></textarea>
               
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <label for="roles">Roles*
                    <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                <select name="roles[]" id="roles" class="form-control select2" multiple="multiple">
                    @foreach($roles as $id => $roles)
                        <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>{{ $roles }}</option>
                    @endforeach
                </select>
               
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
<script src="{{ asset('js/user_create.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
@endsection