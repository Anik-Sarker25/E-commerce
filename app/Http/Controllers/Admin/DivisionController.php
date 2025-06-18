<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Traits\RowIndex;
use App\Http\Controllers\Controller;
use Devfaysal\BangladeshGeocode\Models\District;
use Devfaysal\BangladeshGeocode\Models\Division;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DivisionController extends Controller
{
    use RowIndex;
    public function index() {
        $pageTitle = "All Divisions";
        $breadcrumbs = [
            ['url' => route('admin.countries.index'), 'title' => 'countries'],
            ['url' => route('admin.countries.divisions.index'), 'title' => 'divisions'],
        ];

        if (request()->ajax()) {
            $data = Division::query();

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

        return view('admin.country_settings.division', compact('pageTitle', 'breadcrumbs'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => ['required', 'unique:divisions,name'],
            'bn_name' => ['required', 'unique:divisions,bn_name'],
            'link' => ['required'],
        ]);

        $division = new Division;
        $division->name = $validated['name'];
        $division->bn_name = $validated['bn_name'];
        $division->url = $validated['link'];
        $division->save();

        return response()->json($division);
    }

    public function edit($id) {
        $division = Division::findOrFail($id);
        return response()->json($division);
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'name' => ['required', 'unique:divisions,name,'.$id],
            'bn_name' => ['required', 'unique:divisions,bn_name,'.$id],
            'link' => ['required'],
        ]);

        $division = Division::findOrFail($id);
        $division->name = $validated['name'];
        $division->bn_name = $validated['bn_name'];
        $division->url = $validated['link'];
        $division->save();

        return response()->json($division);
    }

    public function destroy($id){
        $data_check = District::where('division_id', $id)->first();
        if($data_check == false){
            $data = Division::findOrFail($id);
            $data->delete();

            return response()->json($data);
        }else{
            return response()->json('have_district');
        }
    }
}
