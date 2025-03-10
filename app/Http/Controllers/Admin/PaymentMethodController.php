<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Traits\RowIndex;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class PaymentMethodController extends Controller
{
    use RowIndex;
    public function index() {
        $pageTitle = "payment methods";
        $breadcrumbs = [
            ['url' => route('admin.settings.index'), 'title' => 'settings'],
            ['url' => route('admin.settings.paymentMethods.index'), 'title' => 'payment methods'],
        ];

        if (request()->ajax()) {
            $data = PaymentMethod::orderBy('id', 'DESC')->get();

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

        return view('admin.settings.payment_method.payment', compact('pageTitle', 'breadcrumbs'));
    }


    public function store(Request $request) {
        // Validation
        $request->validate([
            'name' => ['required','string','max:255'],
            'image' => $request->hasFile('image') ? ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'] : ['nullable'],
            'link' => ['nullable', 'url',]
        ]);

        try {
            if ($request->hasFile('image')) {
                $manager = new ImageManager(new Driver());
                $image = $manager->read($request->file('image'));
                $assign_name = "payment-".date('his').".".$request->file('image')->getClientOriginalExtension();
                $image->resize(91, 46);
                $image->save(base_path('public/uploads/payment/'.$assign_name, 80, 'png'));
                $imagePath = '/uploads/payment/'.$assign_name;
            }else {
                $imagePath = null;

            }

            PaymentMethod::create([
                'name' => $request->name,
                'image' => $imagePath,
                'link' => $request->link,
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    public function edit($id) {
        $data = PaymentMethod::find($id);
        return response()->json($data);
    }

    public function update(Request $request, $id) {
        // Validation
        $request->validate([
            'name' => ['required','string','max:255'],
            'image' => $request->hasFile('image') ? ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'] : ['nullable'],
            'link' => ['nullable', 'url',]
        ]);

        try {
            $data = PaymentMethod::find($id);
            if ($request->hasFile('image')) {
                if($data->image != null){
                    $old_img = public_path($data->image);
                    if (file_exists($old_img)) {
                        unlink($old_img);
                    }
                }
                $manager = new ImageManager(new Driver());
                $image = $manager->read($request->file('image'));
                $assign_name = "payment-".date('his').".".$request->file('image')->getClientOriginalExtension();
                $image->resize(91, 46);
                $image->save(base_path('public/uploads/payment/'.$assign_name, 80, 'png'));
                $imagePath = '/uploads/payment/'.$assign_name;
            }else {
                $imagePath = $data->image;
            }

            $data->update([
                'name' => $request->name,
                'image' => $imagePath,
                'link' => $request->link,
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    public function destroy($id){
        $data = PaymentMethod::findOrFail($id);
        if($data == true){
            $data->delete();
        }
        return response()->json($data);
    }

    public function removeImage($id) {
        try {
            $data = PaymentMethod::findOrFail($id);
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
