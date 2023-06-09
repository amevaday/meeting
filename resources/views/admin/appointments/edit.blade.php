@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
       Edit Appointment
    </div>

    <div class="card-body">
        <form id="appointment-user-form" name="appointment-user-form" action="{{ route("admin.appointments.update", [$appointment->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="client">Client*</label>
                <select name="client_id" id="client" class="form-control select2">
                    @foreach($clients as $id => $client)
                        <option value="{{ $id }}" {{ (isset($appointment) && $appointment->client ? $appointment->client->id : old('client_id')) == $id ? 'selected' : '' }}>{{ $client }}</option>
                    @endforeach
                </select>
               
            </div>
     
            <div class="form-group">
                <label for="start_time">Start Time*</label>
                <input type="text" id="start_time" name="start_time" class="form-control datetime" value="{{ old('start_time', isset($appointment) ? $appointment->start_time : '') }}">
               
               
            </div>
            <div class="form-group ">
                <label for="finish_time">Finish Time*</label>
                <input type="text" id="finish_time" name="finish_time" class="form-control datetime" value="{{ old('finish_time', isset($appointment) ? $appointment->finish_time : '') }}">
               
                
            </div>
            
            <div class="form-group">
                <label for="services">Meeting Title 
                    <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                <select name="services[]" id="services" class="form-control select2" multiple="multiple">
                    @foreach($services as $id => $services)
                        <option value="{{ $id }}" {{ (in_array($id, old('services', [])) || isset($appointment) && $appointment->services->contains($id)) ? 'selected' : '' }}>{{ $services }}</option>
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