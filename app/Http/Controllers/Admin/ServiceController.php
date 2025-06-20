<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Traits\RowIndex;
use App\Http\Controllers\Controller;
use App\Models\Services;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    use RowIndex;
    public function index() {
        $pageTitle = "services";
        $breadcrumbs = [
            ['url' => route('admin.settings.services.index'), 'title' => 'services'],
        ];

        if (request()->ajax()) {
            $data = Services::orderBy('id', 'DESC')->get();

            return DataTables::of($data)
                ->addColumn('sl', function ($row) {
                    return $this->dt_index($row);
                })
                ->addColumn('icon', function ($row) {
                    if($row->icon) {
                        return '<i class="fas '. $row->icon.'"></i>';
                    }else {
                        return '---';
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn1 = '<button onclick="edit(' . $row->id . ')" type="button" class="btn btn-sm btn-outline-success me-2 mb-2"><i class="fas fa-edit me-2"></i>Edit</button>';
                    $btn2 = '<button onclick="destroy(' . $row->id . ')" type="button" class="btn btn-sm btn-outline-danger mb-2"><i class="fas fa-trash-alt me-2"></i>Delete</button>';
                    return $btn1.$btn2;
                })
                ->rawColumns(['sl', 'icon', 'action'])
                ->make(true);
        }

        return view('admin.settings.services', compact('pageTitle', 'breadcrumbs'));
    }


    public function store(Request $request) {
        // Validation
        $request->validate([
            'name' => ['required','string','max:255'],
            'icon' => ['nullable', 'string','max:255'],
            'description' => ['nullable', 'string','max:255'],
        ]);

        try {

            Services::create([
                'name' => $request->name,
                'icon' => $request->icon,
                'description' => $request->description,
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    public function edit($id) {
        $data = Services::find($id);
        return response()->json($data);
    }

    public function update(Request $request, $id) {
        // Validation
        $request->validate([
            'name' => ['required','string','max:255'],
            'icon' => ['nullable', 'string','max:255'],
            'description' => ['nullable', 'string','max:255'],
        ]);

        try {
            $data = Services::find($id);

            $data->update([
                'name' => $request->name,
                'icon' => $request->icon,
                'description' => $request->description,
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    public function destroy($id){
        $data = Services::findOrFail($id);
        if($data == true){
            $data->delete();
        }
        return response()->json($data);
    }

}
