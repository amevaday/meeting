@extends('layouts.admin')
@section('content')
@can('service_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="form-group srh_w_d">
        <a href="javascript:void(0)" data-url="services/addService" id="add_service" class="btn btn-primary">Add Meeting</a>
    </div>
</div>
@endcan
<div class="card">
    <div class="card-header">
        Meetings Name List
    </div>

    <div class="card-body">
        <table id="service-datatable" class=" table table-bordered table-striped table-hover ajaxTable datatable">
            <thead>
                <tr>
                   
                    <th>
                        Id
                    </th>
                    <th>
                        Name
                    </th>
                    <th>
                       Actions
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

<!-- Add Service Meeting Modal -->
<div class="modal fade" id="ServiceModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="service_modal_content">
        </div>
    </div>
</div>
<!-- End Service Meeting  Modal -->

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
<script src="{{ asset('js/service_list.js') }}"></script>
<script src="{{ asset('js/common.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
@endsection