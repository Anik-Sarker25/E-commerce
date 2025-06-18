<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Traits\RowIndex;
use App\Http\Controllers\Controller;
use App\Models\Village;
use Devfaysal\BangladeshGeocode\Models\Union;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VillageController extends Controller
{
    use RowIndex;
    public function index() {
        $pageTitle = "All Villages";
        $breadcrumbs = [
            ['url' => route('admin.countries.index'), 'title' => 'countries'],
            ['url' => route('admin.countries.villages.index'), 'title' => 'villages'],
        ];
        
        $unions = Union::all();

        if (request()->ajax()) {
            $data = Village::query();

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

        return view('admin.country_settings.village', compact('pageTitle', 'unions', 'breadcrumbs'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'union_id' => ['required'],
            'name' => ['required', 'unique:villages,name'],
            'bn_name' => ['required', 'unique:villages,bn_name'],
            'link' => ['nullable'],
        ]);

        $village = new Village();
        $village->union_id = $validated['union_id'];
        $village->name = $validated['name'];
        $village->bn_name = $validated['bn_name'];
        $village->url = $validated['link'];
        $village->save();

        return response()->json($village);
    }

    public function edit($id) {
        $village = Village::findOrFail($id);
        return response()->json($village);
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'union_id' => ['required'],
            'name' => ['required', 'unique:villages,name,'.$id],
            'bn_name' => ['required', 'unique:villages,bn_name,'.$id],
            'link' => ['nullable'],
        ]);

        $village = Village::findOrFail($id);
        $village->union_id = $validated['union_id'];
        $village->name = $validated['name'];
        $village->bn_name = $validated['bn_name'];
        $village->url = $validated['link'];
        $village->save();

        return response()->json($village);
    }


    public function destroy($id){
        $data = Village::findOrFail($id);
        $data->delete();

        return response()->json($data);
    }
}
