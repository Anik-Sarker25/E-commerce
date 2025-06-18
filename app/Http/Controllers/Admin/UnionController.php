<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Traits\RowIndex;
use App\Http\Controllers\Controller;
use App\Models\Village;
use Devfaysal\BangladeshGeocode\Models\Union;
use Devfaysal\BangladeshGeocode\Models\Upazila;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UnionController extends Controller
{
    use RowIndex;
    public function index() {
        $pageTitle = "All unions";
        $breadcrumbs = [
            ['url' => route('admin.countries.index'), 'title' => 'countries'],
            ['url' => route('admin.countries.unions.index'), 'title' => 'Unions'],
        ];
        
        $upazilas = Upazila::all();

        if (request()->ajax()) {
            $data = Union::query();

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

        return view('admin.country_settings.union', compact('pageTitle', 'upazilas', 'breadcrumbs'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'upazila_id' => ['required'],
            'name' => ['required', 'unique:unions,name'],
            'bn_name' => ['required', 'unique:unions,bn_name'],
            'link' => ['required'],
        ]);

        $union = new Union();
        $union->upazila_id = $validated['upazila_id'];
        $union->name = $validated['name'];
        $union->bn_name = $validated['bn_name'];
        $union->url = $validated['link'];
        $union->save();

        return response()->json($union);
    }

    public function edit($id) {
        $union = Union::findOrFail($id);
        return response()->json($union);
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'upazila_id' => ['required'],
            'name' => ['required', 'unique:unions,name,'.$id],
            'bn_name' => ['required', 'unique:unions,bn_name,'.$id],
            'link' => ['required'],
        ]);

        $union = Union::findOrFail($id);
        $union->upazila_id = $validated['upazila_id'];
        $union->name = $validated['name'];
        $union->bn_name = $validated['bn_name'];
        $union->url = $validated['link'];
        $union->save();

        return response()->json($union);
    }

    public function destroy($id){
        $data_check = Village::where('union_id', $id)->first();
        if($data_check == false){
            $data = Union::findOrFail($id);
            $data->delete();

            return response()->json($data);
        }else{
            return response()->json('have_village');
        }
    }
}
