<form method="post" enctype="multipart/form-data" id="user_form" action="users/addUserData" }}>
    @method('POST')
    @csrf
    <div class="modal-header ">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close"><span
                aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add User</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="name">Name*</label>
            <input type="text" id="name" name="name" class="form-control"
                value="{{ old('name', isset($user) ? $user->name : '') }}">

        </div>
        <div class="form-group">
            <label for="email">Email*</label>
            <input type="email" id="email" name="email" class="form-control"
                value="{{ old('email', isset($user) ? $user->email : '') }}">
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="number" id="phone" name="phone" class="form-control" value="">
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
            <textarea type="text" id="address" name="address" class="form-control"
                value="{{ old('address', isset($user) ? $user->address : '') }}"></textarea>

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
                <option value="{{ $id }}"
                    {{ (in_array($id, old('roles', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>
                    {{ $roles }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <input type="submit" id="submit" name="save" value="Save" class="btn btn-primary">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
</form>
@section('js')
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('js/additional-methods.js') }}"></script>
<script src="{{ asset('js/jszip.min.js') }}"></script>
<script src="{{ asset('js/pdfmake.min.js') }}"></script>
<script src="{{ asset('js/vfs_fonts.js') }}"></script>
<script src="{{ asset('js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('js/buttons.print.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-multiselect.min.js') }}"></script>
<script src="{{ asset('js/user.js') }}"></script>
<script src="{{ asset('js/common.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
@endsection