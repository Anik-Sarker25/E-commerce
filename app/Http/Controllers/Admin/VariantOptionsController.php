<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Constant;
use App\Helpers\Traits\RowIndex;
use App\Http\Controllers\Controller;
use App\Models\VariantOption;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VariantOptionsController extends Controller
{
    use RowIndex;
    public function index() {
        $pageTitle = "variants & stocks";
        $breadcrumbs = [
            ['url' => route('admin.products.index'), 'title' => 'products'],
            ['url' => route('admin.products.variants.index'), 'title' => 'variants & stocks'],
        ];

        if (request()->ajax()) {
            $data = VariantOption::orderBy('id', 'DESC')->get();

            return DataTables::of($data)
                ->addColumn('sl', function ($row) {
                    return $this->dt_index($row);
                })
                ->addColumn('product_id', function ($row) {
                    return $row->products->name ?? '---';
                })
                ->addColumn('item_code', function ($row) {
                    if ($row->products) {
                        return '#'.$row->products->item_code;
                    } else {
                        return '---';
                    }
                })
                ->addColumn('color_family', function ($row) {
                    if ($row->variants) {
                        $image = '<img src="'.asset($row->variants->color_image). '" alt="'. $row->variants->name. '" class="rounded" style="max-width: 32px;">';
                        if($row->variants->color_image) {
                            return $image;
                        }

                        return $row->variants->color_name;
                    } else {
                        return '---';
                    }
                })
                ->addColumn('variant_type', function ($row) {
                    $types = array_flip(Constant::VARIANT_TYPES);

                    return $row->variant_type
                        ? ucfirst(str_replace('_', ' ', $types[$row->variant_type] ?? '---'))
                        : '---';
                })
                ->addColumn('action', function ($row) {
                    $btn1 = '<button onclick="edit(' . $row->id . ')" type="button" class="btn btn-sm btn-outline-success me-2 mb-2"><i class="fas fa-edit me-2"></i>Edit</button>';
                    $btn2 = '<button onclick="destroy(' . $row->id . ')" type="button" class="btn btn-sm btn-outline-danger mb-2"><i class="fas fa-trash-alt me-2"></i>Delete</button>';
                    return $btn1.$btn2;
                })
                ->rawColumns(['sl', 'product_id', 'item_code', 'color_family', 'variant_type', 'action'])
                ->make(true);
        }

        return view('admin.products.variantstock.product_variants_stock', compact('pageTitle', 'breadcrumbs'));
    }
}
