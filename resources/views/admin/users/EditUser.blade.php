<form method="post" enctype="multipart/form-data" id="user_form" action="users/addUserData" }}>
    @method('POST')
    @csrf
    <div class="modal-header ">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close"><span
                aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit User</h4>
       
    </div>
    <div class="modal-body">
    <div class="form-group">
            <label for="name">Name*</label>
            <input name="id" type="hidden" id="id" value="<?php echo $id ?>">
            <input type="text" id="name" name="name" class="form-control"
                value="{{$name}}">

        </div>
        <div class="form-group">
            <label for="email">Email*</label>
            <input type="email" id="email" name="email" class="form-control"
                value="{{$email}}">
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="number" id="phone" name="phone" class="form-control" value="{{$phone}}">
        </div>
        <div class="form-group">
                <label class="col-sm-3 col-form-label">Gender</label>
                <div class="col-sm-9">
                <input type=radio name="gender" value="Male" {{ $gender == 'Male' ? 'checked' : ''}}>Male</option>
                <input type=radio name="gender" value="Female" {{ $gender == 'Female' ? 'checked' : ''}}>Female</option>        
                </div>
            </div>
        <div class="form-group">
            <label for="address">Address*</label>
            <input type="text" id="address" name="address" class="form-control"
                value="{{$address}}">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control">
        </div>
        <div class="form-group">
            <label for="approved">Approved</label>
            <input name="approved" type="hidden" value="0">
            <input value="1" type="checkbox" id="approved" name="approved" {{ $approved || old('approved', 0) === 1 ? 'checked' : '' }}>
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