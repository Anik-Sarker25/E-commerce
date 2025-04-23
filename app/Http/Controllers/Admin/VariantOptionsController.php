<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Constant;
use App\Helpers\Traits\RowIndex;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductVariantsStoreRequest;
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


    public function store(ProductVariantsStoreRequest $request)
    {
        // Check if we should update existing stock
        if (
            $request->color_family !== null &&
            $request->variant_type === null &&
            $request->variant_value === null
        ) {
            $data = VariantOption::where('product_id', $request->product_id)
                ->where('color_family', $request->color_family)
                ->whereNotNull('variant_type')
                ->first();
        
            if ($data) {
                $data->buy_price = $request->buy_price;
                $data->mrp_price = $request->mrp_price;
                $data->discount_price = $request->discount_price;
                $data->sell_price = $request->sell_price;
                $data->stock += $request->stock;
                $data->save();
        
                return response()->json('updated');
            }
        } else {
            // Otherwise, create a new variant option
            $data = new VariantOption();
            $data->product_id = $request->product_id;
            $data->color_family = $request->color_family;
            $data->variant_type = $request->variant_type;
            $data->variant_value = $request->variant_value;
            $data->buy_price = $request->buy_price;
            $data->mrp_price = $request->mrp_price;
            $data->discount_price = $request->discount_price;
            $data->sell_price = $request->sell_price;
            $data->stock = $request->stock;
            $data->save();
        
            return response()->json('created');
        }
    }
    
    public function edit($id)  {
        $data = VariantOption::find($id);
        return response()->json($data);
    }

    public function update(ProductVariantsStoreRequest $request, $id)
    {

        $data = VariantOption::find($id);
        $data->update([
            'product_id' => $request->product_id,
            'color_family' => $request->color_family,
            'variant_type' => $request->variant_type,
            'variant_value' => $request->variant_value,
            'buy_price' => $request->buy_price,
            'mrp_price' => $request->mrp_price,
            'discount_price' => $request->discount_price,
            'sell_price' => $request->sell_price,
            'stock' => $request->stock,
        ]);

        return response()->json();
    }

    public function destroy($id) {
        $data = VariantOption::find($id);
        $data->delete();

        return response()->json();

    }
}
