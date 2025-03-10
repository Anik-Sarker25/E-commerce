<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Traits\RowIndex;
use App\Http\Controllers\Controller;
use App\Models\ChildCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ChildCategoryController extends Controller
{
    use RowIndex;
    public function index() {
        $pageTitle = "All Child categories";
        $breadcrumbs = [
            ['url' => route('admin.categories.index'), 'title' => 'categories'],
            ['url' => route('admin.childcategories.index'), 'title' => 'child categories'],
        ];

        if (request()->ajax()) {
            $data = ChildCategory::orderBy('id', 'DESC')->get();

            return DataTables::of($data)
                ->addColumn('sl', function ($row) {
                    return $this->dt_index($row);
                })
                ->addColumn('subcategory_id', function ($row) {
                    return $row->subcategory->name ?? '---';
                })
                ->addColumn('action', function ($row) {
                    $btn1 = '<button onclick="edit(' . $row->id . ')" type="button" class="btn btn-sm btn-outline-success me-2 mb-2"><i class="fas fa-edit me-2"></i>Edit</button>';
                    $btn2 = '<button onclick="destroy(' . $row->id . ')" type="button" class="btn btn-sm btn-outline-danger mb-2"><i class="fas fa-trash-alt me-2"></i>Delete</button>';
                    return $btn1.$btn2;
                })
                ->rawColumns(['sl', 'subcategory_id', 'action'])
                ->make(true);
        }

        return view('admin.categories.childcategories', compact('pageTitle', 'breadcrumbs'));
    }

    public function store(Request $request) {
        // Validation
        $request->validate([
            'subcategory_id' => ['required','integer'],
            'name' => ['required','string','max:255'],
        ]);

        ChildCategory::create([
            'subcategory_id' => $request->subcategory_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json(['success' => true]);
    }

    public function edit($id) {
        $childcategory = ChildCategory::find($id);
        return response()->json($childcategory);
    }

    public function update(Request $request, $id) {
        // Validation
        $request->validate([
            'subcategory_id' => ['required','integer'],
            'name' => ['required','string','max:255'],
        ]);

        $data = ChildCategory::find($id);

        $data->update([
            'subcategory_id' => $request->subcategory_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id){
        $childcategory = ChildCategory::findOrFail($id);
        $childcategory->delete();
        return response()->json(['success' => true]);
    }
}
