<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Constant;
use App\Helpers\Traits\RowIndex;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    use RowIndex;
    public function index() {
        $pageTitle = "All categories";
        $breadcrumbs = [
            ['url' => route('admin.categories.index'), 'title' => 'categories'],
            ['url' => route('admin.categories.index'), 'title' => 'categories'],
        ];

        if (request()->ajax()) {
            $data = Category::orderBy('id', 'DESC')->get();

            return DataTables::of($data)
                ->addColumn('sl', function ($row) {
                    return $this->dt_index($row);
                })
                ->addColumn('image', function ($row) {
                    if ($row->image) {
                        $image = '<img src="'.asset($row->image). '" alt="'. $row->name. '" class="rounded" style="max-width: 48px;">';
                    } else {
                        $image = '---';
                    }
                    return $image;
                })
                ->addColumn('action', function ($row) {
                    $btn1 = '<button onclick="edit(' . $row->id . ')" type="button" class="btn btn-sm btn-outline-success me-2 mb-2"><i class="fas fa-edit me-2"></i>Edit</button>';
                    $btn2 = '<button onclick="destroy(' . $row->id . ')" type="button" class="btn btn-sm btn-outline-danger mb-2"><i class="fas fa-trash-alt me-2"></i>Delete</button>';
                    return $btn1.$btn2;
                })
                ->rawColumns(['sl', 'image', 'action'])
                ->make(true);
        }

        return view('admin.categories.categories', compact('pageTitle', 'breadcrumbs'));
    }

    public function store(Request $request) {
        // Validation
        $request->validate([
            'name' => ['required','string','max:255'],
            'image' => $request->hasFile('image') ? ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'] : ['nullable'],
        ]);

        try {
            if ($request->hasFile('image')) {
                $manager = new ImageManager(new Driver());
                $image = $manager->read($request->file('image'));
                $assign_name = "image-".date('his').".".$request->file('image')->getClientOriginalExtension();
                $image->resize(200, 200);
                $image->save(base_path('public/uploads/categories/'.$assign_name, 80, 'png'));
                $imagePath = '/uploads/categories/'.$assign_name;
            }else {
                $imagePath = null;

            }

            Category::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'image' => $imagePath,
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    public function edit($id) {
        $category = Category::find($id);
        return response()->json($category);
    }

    public function update(Request $request, $id) {
        // Validation
        $request->validate([
            'name' => ['required','string','max:255'],
            'image' => $request->hasFile('image') ? ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'] : ['nullable'],
        ]);

        try {
            $data = Category::find($id);
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
                $image->resize(200, 200);
                $image->save(base_path('public/uploads/categories/'.$assign_name, 80, 'png'));
                $imagePath = '/uploads/categories/'.$assign_name;
            }else {
                $imagePath = $data->image;
            }

            $data->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'image' => $imagePath,
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    public function destroy($id){
        $check = SubCategory::where('category_id', $id)->first();
        if($check == false) {
            $category = Category::findOrFail($id);
            if($category == true){
                $category->delete();
            }
            return response()->json($category);
        }else {
            return response()->json('have_data');
        }
    }

    public function removeImage($id) {
        try {
            $data = Category::findOrFail($id);
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
