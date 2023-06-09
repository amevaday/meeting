<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Role;
use App\User;
use Gate;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str; 
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        // abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // return view('admin.users.index', compact('users'));
        if ($request->ajax()) {
            $roles = Role::all()->pluck('title');
            $data = User::all()->load('roles');
            if (isset($input['gender'])) {
                $data = $data->where('gender', $input['gender']);
            }
            return Datatables::of($data)
                     ->addIndexColumn()
                     ->filter(function ($instance) use ($request) {
                         if (!empty($request->get('email'))) {
                             $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                 return Str::contains($row['email'], $request->get('email')) ? true : false;
                             });
                         }
                         if (!empty($request->get('approved'))) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains($row['approved'], $request->get('approved')) ? true : false;
                            });
                        }
                         if (!empty($request->get('search'))) {
                             $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                 if (Str::contains(Str::lower($row['email']), Str::lower($request->get('search')))) {
                                     return true;
                                 } elseif (Str::contains(Str::lower($row['name']), Str::lower($request->get('search')))) {
                                     return true;
                                 }

                                 return false;
                             });
                         }
                         if (!empty($request->get('gender'))) {
                             $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                 return Str::contains($row['email'], $request->get('email')) ? true : false;
                             });
                         }
                     })
                     ->addColumn('action', function ($row) {
                         $updateButton = "<button class='btn btn-primary editUser' check_temp='edit' data-id='".$row->id."' data-bs-toggle='modal'>Edit</button>";
                         $deleteButton = "<button class='btn btn-danger deleteUser' data-id='".$row->id."'>Delete</button>";
                         return $updateButton." ".$deleteButton;
                     })
                     ->rawColumns(['action'])
                     ->make(true);
        }

        return view('admin.users.index');
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));
        return redirect()->route('admin.users.index');
    }
    public function addUser(Request $request)
    {
        if ($request->ajax()) {
            $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
            $roles = Role::all()->pluck('title', 'id');
            $data['type'] = 'Add_user';
            return view('admin.users.AddUser', compact('users', 'roles', 'data'));
        }
    }
    public function addUserData(Request $request)
    {
    if ($request->ajax()) {
        $user = User::find($request->id);
         // Check If not equal to empty user data than create otherwise update
        if (!empty($user)) {
                $updateArray = [];
                $updateArray['name'] = $request->name;
                $updateArray['email'] = $request->email;
                $updateArray['phone'] = $request->phone;
                $updateArray['gender'] = $request->gender;
                $updateArray['address'] = $request->address;
                $updateArray['password'] = $request->password;
                $update = User::where('id',$request->id)->update($updateArray);
                //Return responcse Code
                return response()->json([
                    'success' => true,
                    'data' => $update,
                    'message' => "User Updated successfully",
                    'redirect' => route('admin.users.index')
                ]);
        } else {
            //Insert user data
            $user = User::create($request->all());
            $user->roles()->sync($request->input('roles', []));
            //Return responcse Code
            return response()->json([
                    'success' => true,
                    'data' => $user,
                    'message' => "User Added successfully",
                    'redirect' => route('admin.users.index')
                ]);
                }
            }
    }

    public function editUser(Request $request,User $user)
    {
        if($request->ajax()){
            $data['type'] = 'edit_user';
            $user = User::find($request->id);
            $roles = Role::all()->pluck('title', 'id');
            return view('admin.users.EditUser',$user);
        }
    }

    // public function update(Request $request, User $user)
    // {
    //     $user->update($request->all());
    //     $user->roles()->sync($request->input('roles', []));

    //     return redirect()->route('admin.users.index');
    // }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        User::find($user->id)->delete();
        return response()->json([
            'success' => true,
            'message' => "User deleted successfully!",
        ]);
    }
}