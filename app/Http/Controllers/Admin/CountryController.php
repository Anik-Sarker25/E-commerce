<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Traits\RowIndex;
use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class CountryController extends Controller
{
    use RowIndex;
    public function index() {
        $pageTitle = "Countries";
        $breadcrumbs = [
            ['url' => route('admin.countries.index'), 'title' => 'counties'],
        ];

        if (request()->ajax()) {
            $data = Country::orderBy('id', 'DESC')->get();

            return DataTables::of($data)
                ->addColumn('sl', function ($row) {
                    return $this->dt_index($row);
                })
                ->addColumn('action', function ($row) {
                    $btn1 = '<button onclick="edit(' . $row->id . ')" type="button" class="btn btn-sm btn-outline-success me-2 mb-2"><i class="fas fa-edit me-2"></i>Edit</button>';
                    $btn2 = '<button onclick="destroy(' . $row->id . ')" type="button" class="btn btn-sm btn-outline-danger mb-2"><i class="fas fa-trash-alt me-2"></i>Delete</button>';
                    return $btn1;
                })
                ->rawColumns(['sl', 'action'])
                ->make(true);
        }

        return view('admin.country_settings.country', compact('pageTitle', 'breadcrumbs'));
    }

    public function edit($id) {
        $data = Country::find($id);
        return response()->json($data);
    }

    public function update(Request $request, $id) {
        // Validation
        $request->validate([
            'country' => ['required','string','max:255'],
            'currency' => ['required','string','max:255'],
            'symbol' => ['required','string','max:255'],
            'timezone' => ['required','string','max:255'],
        ]);

        $data = Country::find($id);
        $data->name = $request->country;
        $data->currency = $request->currency;
        $data->symbol = $request->symbol;
        $data->timezone = $request->timezone;
        $data->save();

        return response()->json(['success' => true]);
    }

    // public function destroy($id){
    //     $data = Country::findOrFail($id);
    //     $data->delete();

    //     return response()->json($data);
    // }

}
