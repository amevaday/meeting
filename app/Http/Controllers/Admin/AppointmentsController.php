<?php

namespace App\Http\Controllers\Admin;

use App\Appointment;
use App\Client;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAppointmentRequest;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Service;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AppointmentsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Appointment::with(['client', 'services'])->select(sprintf('%s.*', (new Appointment)->table));
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                $updateButton = "<button class='btn btn-primary editAppointment' check_temp='edit' data-id='".$row->id."' data-bs-toggle='modal'>Edit</button>";
                $deleteButton = "<button class='btn btn-danger deleteAppointment' data-id='".$row->id."'>Delete</button>";
                return $updateButton." ".$deleteButton;
            }) 
           ->make();
            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->addColumn('client_name', function ($row) {
                return $row->client ? $row->client->name : '';
            });

           
            $table->editColumn('services', function ($row) {
                $labels = [];

                foreach ($row->services as $service) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $service->name);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'client', 'services']);

            return $table->make(true);
        }

        return view('admin.appointments.index');
    }

    //Open Modal content file 
    public function addAppointment(Request $request)
    {
        if($request->ajax()){
        $clients = Client::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $services = Service::all()->pluck('name', 'id');
        $data['type'] = 'Add_appointment';
        return view('admin.appointments.AddAppointment',compact('clients','services','data'));
        }
    }
    //Insert and Update appointment data
    public function addAppointmentData(Request $request)
    {
        if ($request->ajax()) {    
            $appointment = Appointment::where('client_id',$request->id)->find($request->id);
            $appointment = Appointment::create($request->all());
            // sync->sync up the relationship
            $appointment->services()->sync($request->input('services', []));
            // Create Update Array 
            $updatearray = [];
                $updatearray['start_time'] = $request->post('start_time');
                $updatearray['finish_time'] = $request->post('finish_time');
               // Check If not equal to empty appointment data than create otherwise update
            if(!empty($appointment)){
                $updatearray['start_time'] = $request->start_time;
                $updatearray['finish_time'] = $request->finish_time;
                 $update = Appointment::find($request->id)->update($updatearray);
                //Return responcse Code
                return response()->json([
                    'success' => true,
                    'data' => $update,
                    'message' => "Appointment Updated successfully",
                    'redirect' => route('admin.appointments.index')
                ]);
            } else {
                //Inser appointment data
                $appointment = Appointment::create($request->all());
                $appointment->services()->sync($request->input('services', []));
                  //Return responcse Code
                return response()->json([
                        'success' => true,
                        'data' => $appointment,
                        'message' => "Appointment Added successfully",
                        'redirect' => route('admin.appointments.index')
                    ]);
                }
            }      
        }
   
    // public function edit(Appointment $appointment)
    // {
    //     // 403 HTTP exception if the user is not an admin
    //     abort_if(Gate::denies('appointment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     $clients = Client::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
    //     $services = Service::all()->pluck('name', 'id');
    //     $appointment->load('client', 'services');

    //     return view('admin.appointments.edit', compact('clients','services', 'appointment'));
    // }

    //Edit Modal Open
    public function editAppointment(Request $request,Appointment $appointment)
    {
        if($request->ajax()){
            $data['type'] = 'appointment';
            //Load Client Model   
            $clients = Client::all()->pluck('name','id')->toArray();
            //Load Services Model
            $services = Service::all()->pluck('name', 'id')->toArray();
            // dd($services);
            // Load appointment data
            $appointment::with(['client','services'])->get();
        //    dd($appointment);
            return view('admin.appointments.EditAppointment',compact('clients','services', 'appointment','data'));
        }
    }
   
          
    public function update(Request $request, Appointment $appointment)
    {
        $appointment->update($request->all());
        $appointment->services()->sync($request->input('services', []));
        return response()->json([
            'success' => true,
            'message' => "Appointment updated successfully",
            'data' => $appointment,
            'redirect' => route('admin.appointments.index')
        ]);
       
    }

    public function show(Appointment $appointment)
    {
        // 403 HTTP exception if the user is not an admin
        abort_if(Gate::denies('appointment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $appointment->load('client', 'services');

        return view('admin.appointments.show', compact('appointment'));
    }

    public function destroy(Appointment $appointment)
    {
        // 403 HTTP exception if the user is not an admin
        abort_if(Gate::denies('appointment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $appointment->delete();

        return back();
    }

    public function massDestroy(MassDestroyAppointmentRequest $request)
    {
        Appointment::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
