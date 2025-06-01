<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Traits\RowIndex;
use App\Http\Controllers\Controller;
use App\Models\DeliveryAgent;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AgentController extends Controller
{
    use RowIndex;
    public function index() {
        $pageTitle = "Delivery Agents";
        $breadcrumbs = [
            ['url' => route('admin.categories.index'), 'title' => 'categories'],
            ['url' => route('admin.subcategories.index'), 'title' => 'sub categories'],
        ];

        if (request()->ajax()) {
            $data = DeliveryAgent::orderBy('id', 'DESC')->get();

            return DataTables::of($data)
                ->addColumn('sl', function ($row) {
                    return $this->dt_index($row);
                })
                ->addColumn('category_id', function ($row) {
                    return $row->category->name ?? '---';
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
                ->rawColumns(['sl', 'image', 'category_id', 'action'])
                ->make(true);
        }

        return view('admin.agents.delivery_agents', compact('pageTitle', 'breadcrumbs'));
    }
}
