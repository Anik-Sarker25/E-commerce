<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Constant;
use App\Helpers\Traits\RowIndex;
use App\Http\Controllers\Controller;
use App\Models\DeliveryOption;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class DeliveryController extends Controller
{
    use RowIndex;
    public function index() {
        $pageTitle = "Delivery Options List";
        $breadcrumbs = [
            ['url' => route('admin.settings.index'), 'title' => 'Settings'],
            ['url' => route('admin.settings.delivery.index'), 'title' => 'Delivery Options'],
        ];

        if (request()->ajax()) {
            $data = DeliveryOption::orderBy('id', 'DESC')->get();

            return DataTables::of($data)
                ->addColumn('sl', function ($row) {
                    return $this->dt_index($row);
                })
                ->addColumn('estimated_time', function ($row) {
                    $estimatedTimes = array_flip(Constant::ESTIMATED_TIME);

                    return $estimatedTimes[$row->estimated_time] ?? '---'; // Get text by value
                })
                ->addColumn('tracking_available', function ($row) {
                    $tracking = array_flip(Constant::TRACKING_AVAILABLE);

                    return $tracking[$row->tracking_available] ?? '---'; // Get text by value
                })
                ->addColumn('cost', function ($row) {
                    if ($row->cost) {
                        $cost = country()->symbol . number_format2($row->cost);
                    } else {
                        $cost = '---';
                    }
                    return $cost;
                })
                ->addColumn('action', function ($row) {
                    $btn1 = '<button onclick="edit(' . $row->id . ')" type="button" class="btn btn-sm btn-outline-success me-2 mb-2"><i class="fas fa-edit me-2"></i>Edit</button>';
                    $btn2 = '<button onclick="destroy(' . $row->id . ')" type="button" class="btn btn-sm btn-outline-danger mb-2"><i class="fas fa-trash-alt me-2"></i>Delete</button>';
                    return $btn1.$btn2;
                })
                ->rawColumns(['sl', 'estimated_time', 'tracking_available', 'cost', 'action'])
                ->make(true);
        }

        return view('admin.settings.delivery_options.delivery', compact('pageTitle', 'breadcrumbs'));
    }

    public function store(Request $request) {
        // Validation
        $request->validate([
            'name' => ['required','string','max:255'],
            'estimated_time' => ['required', 'string','max:255'],
            'cost' => ['required', 'numeric'],
            'tracking_available' => ['nullable'],
        ]);

        DeliveryOption::create([
            'name' => $request->name,
            'estimated_time' => $request->estimated_time,
            'cost' => $request->cost,
            'tracking_available' => $request->tracking_available,
        ]);

        return response()->json('success');
    }

    public function edit($id) {
        $data = DeliveryOption::find($id);
        return response()->json($data);
    }

    public function update(Request $request, $id) {
        // Validation
        $request->validate([
            'name' => ['required','string','max:255'],
            'estimated_time' => ['required', 'string','max:255'],
            'cost' => ['required', 'numeric'],
            'tracking_available' => ['nullable'],
        ]);

        $data = DeliveryOption::find($id);

        $data->update([
            'name' => $request->name,
            'estimated_time' => $request->estimated_time,
            'cost' => $request->cost,
            'tracking_available' => $request->tracking_available,
        ]);

        return response()->json('success');
    }

    public function destroy($id){
        $data = DeliveryOption::findOrFail($id);
        if($data == true){
            $data->delete();
        }
        return response()->json('success');
    }

}
