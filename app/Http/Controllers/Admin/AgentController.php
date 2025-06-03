<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Constant;
use App\Helpers\Traits\RowIndex;
use App\Http\Controllers\Controller;
use App\Http\Requests\AgentStoreRequest;
use App\Models\DeliveryAgent;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Yajra\DataTables\Facades\DataTables;

class AgentController extends Controller
{
    use RowIndex;
    public function index() {
        $pageTitle = "Delivery Agents";
        $breadcrumbs = [
            ['url' => route('admin.categories.index'), 'title' => 'categories'],
            ['url' => route('admin.subcategories.index'), 'title' => 'sub categories'],
        ];

        if (request()->ajax()) {
            $data = DeliveryAgent::orderBy('id', 'DESC')->get();

            return DataTables::of($data)
                ->addColumn('sl', function ($row) {
                    return $this->dt_index($row);
                })
                ->addColumn('image', function ($row) {
                    if ($row->image) {
                        $image = '<img src="'.asset($row->image). '" alt="'. $row->name. '" class="rounded" style="max-width: 36px;">';
                    } else {
                        $image = '---';
                    }
                    return $image;
                })
                ->addColumn('active_status', function ($row) {
                    if($row->active_status ==  Constant::STATUS['active']) {
                        $status = '<button type="button" class="btn btn-sm btn-outline-theme">Active</button>';
                    }else {
                        $status = '<button type="button" class="btn btn-sm btn-outline-warning">Deactive</button>';
                    }
                    return $status;
                })
                ->addColumn('work_status', function ($row) {
                    if($row->work_status ==  Constant::AGENT_STATUS['free']) {
                        $work_status = '<button type="button" class="btn btn-sm btn-outline-light">Free</button>';
                    }else {
                        $work_status = '<button type="button" class="btn btn-sm btn-outline-theme">Engage</button>';
                    }
                    return $work_status;
                })
                ->addColumn('action', function ($row) {
                    $btn1 = '<button onclick="edit(' . $row->id . ')" type="button" class="btn btn-sm btn-outline-success me-2 mb-2"><i class="fas fa-edit me-2"></i>Edit</button>';
                    $btn2 = '<button onclick="destroy(' . $row->id . ')" type="button" class="btn btn-sm btn-outline-danger mb-2"><i class="fas fa-trash-alt me-2"></i>Delete</button>';
                    return $btn1.$btn2;
                })
                ->rawColumns(['sl', 'image', 'active_status', 'work_status', 'action'])
                ->make(true);
        }

        return view('admin.agents.delivery_agents', compact('pageTitle', 'breadcrumbs'));
    }
    public function store(AgentStoreRequest $request) {
        try {
            if ($request->hasFile('image')) {
                $manager = new ImageManager(new Driver());
                $image = $manager->read($request->file('image'));
                $assign_name = "image-".date('his').".".$request->file('image')->getClientOriginalExtension();
                $image->resize(175, 225);
                $image->save(base_path('public/uploads/agents/'.$assign_name, 80, 'png'));
                $imagePath = '/uploads/agents/'.$assign_name;
            }else {
                $imagePath = null;

            }

            DeliveryAgent::create([
                'name' => $request->name,
                'phone' => $request->phone_number,
                'vehicle_number' => $request->vehicle_number,
                'image' => $imagePath,
                'nid_number' => $request->nid_number,
                'blood_group' => $request->blood_group,
                'address' => $request->address,
                'marital_status' => $request->marital_status,
                'date_of_birth' => strtotime($request->birthday),
                'active_status' => $request->status,
                'work_status' => $request->engage_status,
            ]);

            return response()->json(['success' => true]);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    public function edit($id) {
        $data = DeliveryAgent::find($id);
        $birthday = dateFormat2($data->date_of_birth);
        return response()->json([
            'data' => $data,
            'birthday' => $birthday
        ]);
    }

    public function update(AgentStoreRequest $request, $id) {

        try {
            $data = DeliveryAgent::find($id);
            if ($request->hasFile('image')) {
                if($data->image != null){
                    $old_img = public_path($data->image);
                    if (file_exists($old_img)) {
                        unlink($old_img);
                    }
                }
                $manager = new ImageManager(new Driver());
                $image = $manager->read($request->file('image'));
                $assign_name = "image-".date('his').".".$request->file('image')->getClientOriginalExtension();
                $image->resize(175, 225);
                $image->save(base_path('public/uploads/agents/'.$assign_name, 80, 'png'));
                $imagePath = '/uploads/agents/'.$assign_name;
            }else {
                $imagePath = $data->image;

            }

            $data->update([
                'name' => $request->name,
                'phone' => $request->phone_number,
                'vehicle_number' => $request->vehicle_number,
                'image' => $imagePath,
                'nid_number' => $request->nid_number,
                'blood_group' => $request->blood_group,
                'address' => $request->address,
                'marital_status' => $request->marital_status,
                'date_of_birth' => strtotime($request->birthday),
                'active_status' => $request->status,
                'work_status' => $request->engage_status,
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }

    }

    public function destroy($id){
        // if if has related data or engage with any client work then delition not possible set this conditon later
        $check = false;
        if($check == false) {
            $agent = DeliveryAgent::findOrFail($id);
            if($agent == true){
                // unlink old image
                if($agent->image != null){
                    $old_img = public_path($agent->image);
                    if (file_exists($old_img)) {
                        unlink($old_img);
                    }
                }
                // delete data
                $agent->delete();
            }
            return response()->json();
        }else {
            return response()->json('have_data');
        }
    }

    public function removeImage($id) {
        try {
            $data = DeliveryAgent::findOrFail($id);
            if($data->image != null){
                $old_img = public_path($data->image);
                if (file_exists($old_img)) {
                    unlink($old_img);
                }
            }
            $data->image = null;
            $data->save();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

}
