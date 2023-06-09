<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ClientsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Client::query()->select(sprintf('%s.*', (new Client)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $updateButton = "<button class='btn btn-primary editClient' check_temp='edit' data-id='".$row->id."' data-bs-toggle='modal'>Edit</button>";
                $deleteButton = "<button class='btn btn-danger deleteClient' data-id='".$row->id."'>Delete</button>";
                return $updateButton." ".$deleteButton;
            }) 
           ->make();
            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('phone', function ($row) {
                return $row->phone ? $row->phone : "";
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.clients.index');
    }

    //Open Modal content file 
    public function addClient(Request $request)
    {
        if($request->ajax()){
          $data['type'] = 'Add_client';
          return view('admin.clients.AddClient',$data);
        }
    }
    //Insert and Update Client data
    public function addClientData(Request $request)
    {
      
        if ($request->ajax()) {    
            $client = Client::find($request->id);
            // Create Update Array 
            $updatearray = [];
                $updatearray['name'] = $request->post('name');
                $updatearray['phone'] = $request->post('phone');
                $updatearray['email'] = $request->post('email');
                // Check If not equal to empty client data than create otherwise update
            if(!empty($client)){
                $updatearray['name'] = $request->name;
                $updatearray['phone'] = $request->phone;
                $updatearray['email'] = $request->email;
                $update = Client::find($request->id)->update($updatearray);
                //Return responcse Code
                return response()->json([
                    'success' => true,
                    'data' => $update,
                    'message' => "Client Updated successfully",
                    'redirect' => route('admin.clients.index')
                ]);
            } else {
                //Inser Client data
                $client = Client::create($request->all());
                  //Return responcse Code
                return response()->json([
                        'success' => true,
                        'data' => $client,
                        'message' => "Client Added successfully",
                        'redirect' => route('admin.clients.index')
                    ]);
                }
            }      
        }
   
        //Edit Modal Open
    public function editClient(Request $request)
    {
        if($request->ajax()){
            $data['type'] = 'edit_client';
            //Find Client id
            $client = Client::find($request->id);
            return view('admin.clients.EditClient',$client);
        }
    }
   
    //delete Client Function
    public function destroy(Client $client)
    {
        Client::find($client->id)->delete();
        return response()->json([
            'success' => true,
            'message' => "Client deleted successfully!",
        ]);
    }
}
