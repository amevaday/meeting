@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
      Edit User
    </div>

    <div class="card-body">
        <form id="create-user-form" name="create-user-form" action="{{ route("admin.users.update", [$user->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($user) ? $user->name : '') }}" required>
            </div>
            <div class="form-group ">
                <label for="email">Email*</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', isset($user) ? $user->email : '') }}" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="number" id="phone" name="phone" class="form-control"
                value="{{ old('phone', isset($user) ? $user->phone : '') }}" 
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-form-label">Gender</label>
                <div class="col-sm-9">
                <input type=radio name="gender" value="Male" {{ $user->gender == 'Male' ? 'checked' : ''}}>Male</option>
                <input type=radio name="gender" value="Female" {{ $user->gender == 'Female' ? 'checked' : ''}}>Female</option>        
                </div>
            </div>
            <div class="form-group">
                <label for="address">Address*</label>
                <input type="text" id="address" name="address" class="form-control" value="{{ old('address', isset($user) ? $user->address : '') }}" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" value="{{ old('password', isset($user) ? $user->password : '') }}"required>
            </div>
            <div class="form-group">
                <label for="roles">Roles*
                    <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                <select name="roles[]" id="roles" class="form-control select2" multiple="multiple" required>
                    @foreach($roles as $id => $roles)
                        <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>{{ $roles }}</option>
                    @endforeach
                </select>
               
                
            </div>
            <div class="form-group">
                            <label for="approved">Approved</label>
                            <input name="approved" type="hidden" value="0">
                            <input value="1" type="checkbox" id="approved" name="approved" {{ (isset($user) && $user->approved) || old('approved', 0) === 1 ? 'checked' : '' }}>
                           
                            
            </div>
            <div>
                <input type="submit" name="save" value="Save" class="btn btn-primary">
            </div>
        </form>


    </div>
</div>
@endsection