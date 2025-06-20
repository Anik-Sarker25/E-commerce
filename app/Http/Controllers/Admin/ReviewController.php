<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Constant;
use App\Helpers\Traits\RowIndex;
use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReviewController extends Controller
{
    use RowIndex;
    public function index() {
        $pageTitle = "Reviews & Ratings";
        $breadcrumbs = [
            ['url' => route('admin.feedbackHub.reviews.index'), 'title' => 'Reviews & ratings'],
        ];

        if (request()->ajax()) {
            $data = ProductReview::all();

            return DataTables::of($data)
                ->addColumn('sl', function ($row) {
                    return $this->dt_index($row);
                })
                ->addColumn('product_id', function ($row) {
                     if($row->product) {
                        $product_name = limitText($row->product->name, 9);
                        return '<div style="width: 200px;">' . $product_name . '</div>';
                    }else {
                        $product = '----';
                    }
                    return $product;
                })
                ->addColumn('user_id', function ($row) {
                     if($row->user_id) {
                        $user = $row->user->name;
                    }else {
                        $user = '----';
                    }
                    return $user;
                })
                ->addColumn('invoice_id', function ($row) {
                    if ($row->invoice_id) {
                        return '<div style="width: 100px;">'.adminFormatedInvoiceId($row->invoice_id).'</div>';
                    } else {
                        return '---';
                    }
                })
                ->addColumn('rating', function ($row) {
                    if ($row->rating) {
                        return $row->rating . ' Star';
                    } else {
                        return '---';
                    }
                })
                ->addColumn('delivery_rating', function ($row) {
                    if ($row->delivery_rating) {
                        return $row->delivery_rating . ' Star';
                    } else {
                        return '---';
                    }
                })
                ->addColumn('review', function ($row) {
                    if ($row->review) {
                        $review = '<textarea class="form-control" style="width:200px; cols="30" rows="2">'. $row->review .'</textarea>';
                    } else {
                        $review = '---';
                    }
                    return $review;
                })
                ->addColumn('delivery_review', function ($row) {
                    if ($row->delivery_review) {
                        $delivery_review = '<textarea class="form-control" style="width:150px; cols="30" rows="2">'. $row->delivery_review .'</textarea>';
                    } else {
                        $delivery_review = '---';
                    }
                    return $delivery_review;
                })
                ->addColumn('admin_comment', function ($row) {
                    if ($row->admin_comment) {
                        $admin_comment = '<textarea class="form-control" style="width:150px; cols="30" rows="2">'. $row->admin_comment .'</textarea>';
                    } else {
                        $admin_comment = '---';
                    }
                    return $admin_comment;
                })
                ->addColumn('image', function ($row) {
                    if ($row->image) {
                        $image = '<img src="'.asset($row->image). '" alt="'. $row->name. '" class="rounded" style="max-width: 36px;">';
                    } else {
                        $image = '---';
                    }
                    return $image;
                })
                ->addColumn('status', function ($row) {
                    $review_status = Constant::REVIEW_STATUS;

                    $select = '<select name="select_agent" class="form-select" style="width: 150px;" onchange="changeStatus(this.value, ' . $row->id . ')">';

                    foreach ($review_status as $label => $value) {
                        $selected = ($row->status == $value) ? 'selected' : '';
                        $select .= '<option ' . $selected . ' value="' . $value . '">' . $label . '</option>';
                    }

                    $select .= '</select>';
                    return $select;
                })

                ->addColumn('action', function ($row) {
                    $btn1 = '<div  style="min-width:100px;"><button onclick="destroy(' . $row->id . ')" type="button" class="btn btn-sm btn-outline-danger mb-2"><i class="fas fa-trash-alt me-2"></i>Delete</button></div>';
                    return $btn1;
                })
                ->rawColumns(['sl', 'product_id', 'invoice_id', 'image', 'review', 'delivery_review', 'admin_comment', 'status', 'action'])
                ->make(true);
        }

        return view('admin.feedback_hub.reviews.review', compact('pageTitle', 'breadcrumbs'));
    }

    public function updateStatus(Request $request, $id) {
        $validated = $request->validate([
            'status' => ['required', 'max:20'],
        ]);

        $review = ProductReview::find($id);
        $review->status = $validated['status'];
        $review->save();

        $statusLabels = array_flip(Constant::REVIEW_STATUS);

        $response_data = [
            'status' => $review->status,
            'label' => $statusLabels[$review->status] ?? 'updated'
        ];

        return response()->json($response_data);
    }

    public function destroy($id){
        $data = ProductReview::findOrFail($id);
        if($data == true){
            $data->delete();
        }
        return response()->json($data);
    }
}
