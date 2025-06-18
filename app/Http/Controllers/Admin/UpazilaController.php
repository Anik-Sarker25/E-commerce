<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Traits\RowIndex;
use App\Http\Controllers\Controller;
use Devfaysal\BangladeshGeocode\Models\District;
use Devfaysal\BangladeshGeocode\Models\Union;
use Devfaysal\BangladeshGeocode\Models\Upazila;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UpazilaController extends Controller
{
    use RowIndex;
    public function index() {
        $pageTitle = "All Upazilas";
        $breadcrumbs = [
            ['url' => route('admin.countries.index'), 'title' => 'countries'],
            ['url' => route('admin.countries.upazilas.index'), 'title' => 'Upazilas'],
        ];
        
        $districts = District::all();

        if (request()->ajax()) {
            $data = Upazila::query();

            return DataTables::of($data)
                ->addColumn('sl', function ($row) {
                    return $this->dt_index($row);
                })
              ->addColumn('url', function ($row) {
                    if ($row->url) {
                        // Ensure URL starts with http:// or https://
                        $url = $row->url;
                        if (!preg_match('/^https?:\/\//', $url)) {
                            $url = 'http://' . $url;
                        }

                        return '<a href="' . e($url) . '" target="_blank" rel="noopener noreferrer">'
                            . e($url) .
                            '</a>';
                    } else {
                        return '---';
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn1 = '<button onclick="edit(' . $row->id . ')" type="button" class="btn btn-sm btn-outline-success me-2 mb-2"><i class="fas fa-edit me-2"></i>Edit</button>';
                    $btn2 = '<button onclick="destroy(' . $row->id . ')" type="button" class="btn btn-sm btn-outline-danger mb-2"><i class="fas fa-trash-alt me-2"></i>Delete</button>';
                    return $btn1.$btn2;
                })
                ->rawColumns(['sl', 'url', 'action'])
                ->make(true);
        }

        return view('admin.country_settings.upazila', compact('pageTitle', 'districts', 'breadcrumbs'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'district_id' => ['required'],
            'name' => ['required', 'unique:upazilas,name'],
            'bn_name' => ['required', 'unique:upazilas,bn_name'],
            'link' => ['required'],
        ]);

        $upazila = new Upazila();
        $upazila->district_id = $validated['district_id'];
        $upazila->name = $validated['name'];
        $upazila->bn_name = $validated['bn_name'];
        $upazila->url = $validated['link'];
        $upazila->save();

        return response()->json($upazila);
    }

    public function edit($id) {
        $upazila = Upazila::findOrFail($id);
        return response()->json($upazila);
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'district_id' => ['required'],
            'name' => ['required', 'unique:upazilas,name,'.$id],
            'bn_name' => ['required', 'unique:upazilas,bn_name,'.$id],
            'link' => ['required'],
        ]);

        $upazila = Upazila::findOrFail($id);
        $upazila->district_id = $validated['district_id'];
        $upazila->name = $validated['name'];
        $upazila->bn_name = $validated['bn_name'];
        $upazila->url = $validated['link'];
        $upazila->save();

        return response()->json($upazila);
    }


    public function destroy($id){
        $data_check = Union::where('upazila_id', $id)->first();
        if($data_check == false){
            $data = Upazila::findOrFail($id);
            $data->delete();

            return response()->json($data);
        }else{
            return response()->json('have_union');
        }
    }
}
