<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Constant;
use App\Helpers\Traits\RowIndex;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StockController extends Controller
{
    use RowIndex;
    public function index() {
        $pageTitle = "product stock";
        $breadcrumbs = [
            ['url' => route('admin.products.index'), 'title' => 'products'],
            ['url' => route('admin.products.stock'), 'title' => 'Stocks'],
        ];
        if (request()->ajax()) {
            $data = Product::orderBy('id', 'DESC')->get();

            return DataTables::of($data)
                ->addColumn('sl', function ($row) {
                    return $this->dt_index($row);
                })
                ->addColumn('item_code', function ($row) {
                    if ($row->item_code) {
                        return '#'.$row->item_code;
                    } else {
                        return '---';
                    }
                })
                ->addColumn('stock_quantity', function ($row) {
                    if ($row->variantOptions && $row->variantOptions->count()) {
                        return $row->variantOptions->sum('stock');
                    } else {
                        return '0';
                    }
                })
                ->addColumn('total_sale', function ($row) {
                    return '0';
                })
                ->addColumn('stock', function ($row) {
                    if ($row->stock_quantity) {
                        return $row->stock_quantity;
                    } else {
                        return '0';
                    }
                })
                ->rawColumns(['sl', 'stock_quantity', 'total_sale', 'stock', 'item_code'])
                ->make(true);
        }

        return view('admin.products.stock', compact('pageTitle', 'breadcrumbs'));
    }
}
