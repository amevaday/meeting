@extends('layouts.admin')
@section('content')

<div style="margin-bottom: 10px;" class="row">
<div class="col-lg-12">
        <a href="javascript:void(0)" data-url="appointments/addAppointment" id="add_appointment" class="btn btn-primary">Add Appointment</a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        Meeting list
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Appointment">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        Id
                    </th>
                    <th>
                        Client Name
                    </th>
                    <th>
                        Start Time
                    </th>
                    <th>
                        Finish Time
                    </th>
                    <th>
                        Meeting Name
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>


    </div>
</div>
@endsection

<!-- Add Appointment Modal -->
<div class="modal fade" id="AppointmentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="appointment_modal_content">
        </div>
    </div>
</div>
<!-- End Appointment Modal -->

@section('scripts')
@parent
<script>
$(function() {
    var dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
    @can('appointment_delete')
    var deleteButtonTrans = 'Delete';
    var deleteButton = {
        text: deleteButtonTrans,
        url: "{{ route('admin.appointments.massDestroy') }}",
        method:"POST",
        className: 'btn-danger',
        action: function(e, dt, node, config) {
            var ids = $.map(dt.rows({
                selected: true
            }).data(), function(entry) {
                return entry.id
            });

            if (ids.length === 0) {
                alert('{{ trans('global.datatables.zero_selected ') }}')

                return
            }

            if (confirm('{{ trans('global.areYouSure ') }}')) {
                $.ajax({
                        headers: {
                            'x-csrf-token': _token
                        },
                        method: 'POST',
                        url: config.url,
                        data: {
                            ids: ids,
                            _method: 'DELETE'
                        }
                    })
                    .done(function() {
                        location.reload()
                    })
            }
        }
    }
    dtButtons.push(deleteButton)
    @endcan

    var appointments = {
        buttons: dtButtons,
        processing: true,
        serverSide: true,
        retrieve: true,
        aaSorting: [],
        ajax: "{{ route('admin.appointments.index') }}",
        
        columns: [{
                data: 'placeholder',
                name: 'placeholder'
            },
            {
                data: 'id',
                name: 'id'
            },
            {
                data: 'client_name',
                name: 'client.name'
            },
            {
                data: 'start_time',
                name: 'start_time'
            },
            {
                data: 'finish_time',
                name: 'finish_time'
            },
            {
                data: 'services',
                name: 'services.name'
            },
            {
                data: 'actions',
                name: '{{ trans('global.actions ') }}'
            }
        ],
        order: [
            [1, 'desc']
        ],
        pageLength: 100,
    };
    $('.datatable-Appointment').DataTable(appointments);
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });

});
</script>
@endsection
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
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/appointment.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
@endsection