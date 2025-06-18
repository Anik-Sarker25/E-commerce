<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Traits\RowIndex;
use App\Http\Controllers\Controller;
use Devfaysal\BangladeshGeocode\Models\District;
use Devfaysal\BangladeshGeocode\Models\Division;
use Devfaysal\BangladeshGeocode\Models\Upazila;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DistrictController extends Controller
{
    use RowIndex;
    public function index() {
        $pageTitle = "All Districts";
        $breadcrumbs = [
            ['url' => route('admin.countries.index'), 'title' => 'countries'],
            ['url' => route('admin.countries.districts.index'), 'title' => 'Districts'],
        ];
        
        $divisions = Division::all();

        if (request()->ajax()) {
            $data = District::query();

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

        return view('admin.country_settings.district', compact('pageTitle', 'divisions', 'breadcrumbs'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'division_id' => ['required'],
            'name' => ['required', 'unique:districts,name'],
            'bn_name' => ['required', 'unique:districts,bn_name'],
            'link' => ['required'],
        ]);

        $district = new District();
        $district->division_id = $validated['division_id'];
        $district->name = $validated['name'];
        $district->bn_name = $validated['bn_name'];
        $district->url = $validated['link'];
        $district->save();

        return response()->json($district);
    }

    public function edit($id) {
        $district = District::findOrFail($id);
        return response()->json($district);
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'division_id' => ['required'],
            'name' => ['required', 'unique:districts,name,'.$id],
            'bn_name' => ['required', 'unique:districts,bn_name,'.$id],
            'link' => ['required'],
        ]);

        $district = District::findOrFail($id);
        $district->division_id = $validated['division_id'];
        $district->name = $validated['name'];
        $district->bn_name = $validated['bn_name'];
        $district->url = $validated['link'];
        $district->save();

        return response()->json($district);
    }

    public function destroy($id){
        $data_check = Upazila::where('district_id', $id)->first();
        if($data_check == false){
            $data = District::findOrFail($id);
            $data->delete();

            return response()->json($data);
        }else{
            return response()->json('have_upazila');
        }
    }
}
