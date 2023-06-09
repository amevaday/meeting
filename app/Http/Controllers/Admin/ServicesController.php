<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ServicesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Service::query()->select(sprintf('%s.*', (new Service())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $updateButton = "<button class='btn btn-primary editService' check_temp='edit' data-id='".$row->id."' data-bs-toggle='modal'>Edit</button>";
                $deleteButton = "<button class='btn btn-danger deleteService' data-id='".$row->id."'>Delete</button>";
                return $updateButton." ".$deleteButton;
            }) 
           ->make();

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });


            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.services.index');
    }

   //Open Modal content file 
   public function addService(Request $request)
   {
       if($request->ajax()){
         $data['type'] = 'Add_service';
         return view('admin.services.AddService',$data);
       }
   }
   //Insert and Update Service data
   public function addServiceData(Request $request)
   {
        if ($request->ajax()) {    
           $service = Service::find($request->id);
           // Create Update Array 
           $updatearray = [];
               $updatearray['name'] = $request->post('name');
               // Check If not equal to empty Service data than create otherwise update
           if(!empty($service)){
               $updatearray['name'] = $request->name;
               $update = Service::find($request->id)->update($updatearray);
               //Return responcse Code
               return response()->json([
                   'success' => true,
                   'data' => $update,
                   'message' => "Service Updated successfully",
                   'redirect' => route('admin.services.index')
               ]);
           } else {
               //Inser Service data
               $service = Service::create($request->all());
                 //Return responcse Code
               return response()->json([
                       'success' => true,
                       'data' => $service,
                       'message' => "Service Added successfully",
                       'redirect' => route('admin.services.index')
                   ]);
               }
           }      
       }
  
    //Edit services Modal Open
    public function editService(Request $request,Service $service)
    {
        if($request->ajax()){
            $data['type'] = 'edit_service';
            //Find service id
            $service = Service::find($request->id);
            return view('admin.services.EditService',$service);
        }
    }
   
    //delete service Function
   public function destroy(Service $service)
   {
       Service::find($service->id)->delete();
       return response()->json([
           'success' => true,
           'message' => "Service deleted successfully!",
       ]);
   }
}