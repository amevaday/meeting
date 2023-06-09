<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPermissionRequest;
use App\Permission;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionsController extends Controller
{
    public function index()
    {
        // 403 HTTP exception if the user is not an admin
        abort_if(Gate::denies('permission_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permissions = Permission::all();

        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        // 403 HTTP exception if the user is not an admin
        abort_if(Gate::denies('permission_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.permissions.create');
    }

     //Open Modal content file 
     public function addPermission(Request $request)
     {
         if($request->ajax()){
           $data['type'] = 'Add_permission';
           return view('admin.permissions.AddPermission',$data);
         }
     }
     //Insert and Update Permission data
     public function addPermissionData(Request $request)
     {
        if ($request->ajax()) {    
             $permission = Permission::find($request->id);
             // Create Update Array 
             $updatearray = [];
                 $updatearray['title'] = $request->post('title');
                 // Check If not equal to empty Permission data than create otherwise update
             if(!empty($permission)){
                 $updatearray['title'] = $request->title;
                 $update = Permission::find($request->id)->update($updatearray);
                 //Return responcse Code
                 return response()->json([
                     'success' => true,
                     'data' => $update,
                     'message' => "Permission Updated successfully",
                     'redirect' => route('admin.permissions.index')
                 ]);
             } else {
                 //Insert Permission data
                 $permission = Permission::create($request->all());
                   //Return responcse Code
                 return response()->json([
                         'success' => true,
                         'data' => $permission,
                         'message' => "Permission Added successfully",
                         'redirect' => route('admin.permissions.index')
                     ]);
                 }
             }      
         }

    public function store(Request $request)
    {
        $permission = Permission::create($request->all());
        return response()->json([
            'success' => true,
            'data' => $permission,
            'message' => "Permission Added successfully",
            'redirect' => route('admin.permissions.index')
        ]);
        
    }

    public function edit(Permission $permission)
    {
        // 403 HTTP exception if the user is not an admin
        abort_if(Gate::denies('permission_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $permission->update($request->all());
        return response()->json([
            'success' => true,
            'message' => "permission updated successfully",
            'data' => $permission,
            'redirect' => route('admin.permissions.index')
        ]);
       
    }

    public function show(Permission $permission)
    {
        // 403 HTTP exception if the user is not an admin
        abort_if(Gate::denies('permission_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.permissions.show', compact('permission'));
    }

    public function destroy(Permission $permission)
    {
        // 403 HTTP exception if the user is not an admin
        abort_if(Gate::denies('permission_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permission->delete();

        return back();
    }

    public function massDestroy(MassDestroyPermissionRequest $request)
    {
        Permission::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}