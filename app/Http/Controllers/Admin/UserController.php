<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Constant;
use App\Helpers\Traits\RowIndex;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    use RowIndex;
    public function index() {

        $pageTitle = 'all users';
        $breadcrumbs = [
            ['url' => route('admin.users.index'), 'title' => 'users'],
            ['url' => route('admin.users.index'), 'title' => 'all users'],
        ];
        if (request()->has('blocked')){
            $pageTitle = 'blocked users';
            $breadcrumbs = [
                ['url' => route('admin.users.index'), 'title' => 'users'],
                ['url' => url('admin/users?blocked'), 'title' => 'blocked users'],
            ];
        }


        if (request()->ajax()) {
            if (request()->has('blocked')){
                $users = User::where('status', Constant::USER_STATUS['blocked'])->orderBy('id', 'DESC')->get();
            }else {
                $users = User::orderBy('id', 'DESC')->get();
            }

            return DataTables::of($users)
                ->addColumn('sl', function ($row) {
                    return $this->dt_index($row); // this method generates the index
                })
                ->addColumn('role', function ($row) {
                    if($row->role ==  Constant::USER_TYPE['customer']) {
                        $role = 'Customer';
                    }else {
                        $role = '----';
                    }
                    return $role;
                })
                ->addColumn('status', function ($row) {
                    if($row->status ==  Constant::USER_STATUS['active']) {
                        $status = '<button type="button" class="btn btn-sm btn-outline-success">Active</button>';
                    }elseif($row->status == Constant::USER_STATUS['deactive']) {
                        $status = '<button type="button" class="btn btn-sm btn-outline-warning">Deactive</button>';
                    }else {
                        $status = '<button type="button" class="btn btn-sm btn-outline-danger">Blocked</button>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $btn1 = '<a href="'.route('admin.users.edit', $row->id).'" type="button" class="btn btn-sm btn-outline-success mb-2 me-2"><i class="fas fa-edit me-2"></i>Edit</a>';
                    $btn2 = '<button onclick="destroy(' . $row->id . ')" type="button" class="btn btn-sm btn-outline-danger mb-2"><i class="fas fa-trash-alt me-2"></i>Delete</button>';
                    return $btn1.$btn2;
                })
                ->rawColumns(['sl', 'role', 'status', 'action'])
                ->make(true);
        }

        return view('admin.users.users', compact('pageTitle', 'breadcrumbs'));
    }

    public function create() {
        $user = "";
        $breadcrumbs = [
            ['url' => route('admin.users.index'), 'title' => 'users'],
            ['url' => route('admin.users.create'), 'title' => 'add users'],
        ];
        $pageTitle = 'add users';

        return view('admin.users.create', compact('pageTitle', 'breadcrumbs', 'user'));
    }

    public function store(UserStoreRequest $request)
    {
        try {
            $user = new User();
            $fields = [
                'name'     => 'name',
                'email'    => 'email',
                'phone'    => 'phone',
                'gender'   => 'gender',
                'country'  => 'country_id',
                'division' => 'division_id',
                'district' => 'district_id',
                'upazila'  => 'upazila_id',
                'address'  => 'address',
                'status'   => 'status',
            ];

            foreach ($fields as $requestField => $modelField) {
                if ($request->has($requestField)) {
                    $user->$modelField = $request->input($requestField); // Save only non-null values
                }
            }
            if($request->has('birthday')) {
                $user->role = strtotime($request->birthday);
            }
            if($request->has('password')) {
                $user->password = Hash::make($request->password);
                $user->show_password = $request->password;
            }
            $user->role = Constant::USER_TYPE['customer'];

            $user->save();

            return response()->json();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function edit($id) {
        $breadcrumbs = [
            ['url' => route('admin.users.index'), 'title' => 'users'],
            ['url' => route('admin.users.edit', $id), 'title' => 'edit user'],
        ];
        $pageTitle = 'edit user';

        $user = User::find($id);

        return view('admin.users.create', compact('pageTitle', 'breadcrumbs', 'user'));
    }

    public function update(UserUpdateRequest $request, $id)
    {
        try {
            // update user
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->gender = $request->gender;
            $user->birthday = strtotime($request->birthday);
            $user->country_id = $request->country;
            $user->division_id = $request->division;
            $user->district_id = $request->district;
            $user->upazila_id = $request->upazila;
            $user->address = $request->address;
            $user->role = Constant::USER_TYPE['customer'];
            $user->status = $request->status;
            $user->save();

            return response()->json();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json();
    }
}
