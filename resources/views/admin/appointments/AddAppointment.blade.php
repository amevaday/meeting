<form method="post" enctype="multipart/form-data" id="appointment_form" action="appointments/addAppointmentData" }}>
    @method('POST')
    @csrf
    <div class="modal-header ">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close"><span
                aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Appointment</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="client">Client*</label>
            <select name="client_id" id="client" class="form-control select2">
                @foreach($clients as $id => $client)
                <option value="{{ $id }}"
                    {{ (isset($appointment) && $appointment->client ? $appointment->client->id : old('client_id')) == $id ? 'selected' : '' }}>
                    {{ $client }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group ">
            <label for="start_time">Start Time*</label>
            <input type="text" id="start_time" name="start_time" class="form-control datetimepicker"
                value="">
        </div>
        <div class="form-group ">
            <label for="finish_time">Finish Time*</label>
            <input type="text" id="finish_time" name="finish_time" class="form-control datetimepicker"
                value="">
        </div>
        <div class="form-group ">
            <label for="services">Choose Meeting Title
                <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
            <select name="services[]" id="services" class="form-control select2" multiple="multiple">
                @foreach($services as $id => $services)
                <option value="{{ $id }}"
                    {{ (in_array($id, old('services', [])) || isset($appointment) && $appointment->services->contains($id)) ? 'selected' : '' }}>
                    {{ $services }}</option>
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
<script src="{{ asset('js/appointment.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>

@endsection