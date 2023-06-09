
<form method="post" enctype="multipart/form-data" id="permission_form" action="permissions/addPermissionData" }}>
    @method('POST')
    @csrf
    <div class="modal-header ">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close"><span
                aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Permission</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
                <label for="title">Title*</label>
                <input type="text" id="title" name="title" class="form-control" value="">
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
<script src="{{ asset('js/permission.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
@endsection