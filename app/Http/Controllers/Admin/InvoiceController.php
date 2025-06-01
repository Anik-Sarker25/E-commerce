<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Constant;
use App\Helpers\Traits\RowIndex;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{
    use RowIndex;
    public function index() {

        $pageTitle = "Requested Orders";

        $queryParams = [
            'confirmed_orders' => 'Confirmed Orders',
            'processing_orders' => 'Processing Orders',
            'shipped_orders' => 'Shipped Orders',
            'delivered_orders' => 'Delivered Orders',
            'cancelled_orders' => 'cancelled Orders',
            'refunded_orders' => 'Refunded Orders',
            'returned_orders' => 'Returned Orders'
        ];

        foreach ($queryParams as $key => $title) {
            if (request()->has($key)) {
                $pageTitle = $title;
                $breadcrumbKey = $key;
                break;
            }
        }

        $breadcrumbs = [
            ['url' => route('admin.orders.index'), 'title' => 'Orders'],
            ['url' => isset($breadcrumbKey) ? route('admin.orders.index', [$breadcrumbKey => '']) : route('admin.orders.index'), 'title' => $pageTitle]
        ];


        if (request()->ajax()) {

            $data = Invoice::orderBy('id', 'DESC');

            if(request()->has('confirmed_orders')) {
                $data = $data->where('status', Constant::ORDER_STATUS['confirmed']);
            }else if (request()->has('processing_orders'))  {
                $data = $data->where('status', Constant::ORDER_STATUS['processing']);
            }
            else if (request()->has('shipped_orders'))  {
                $data = $data->where('status', Constant::ORDER_STATUS['shipped']);
            }
            else if (request()->has('delivered_orders'))  {
                $data = $data->where('status', Constant::ORDER_STATUS['delivered']);
            }
            else if (request()->has('cancelled_orders'))  {
                $data = $data->where('status', Constant::ORDER_STATUS['cancelled']);
            }
            else if (request()->has('refunded_orders'))  {
                $data = $data->where('status', Constant::ORDER_STATUS['refunded']);
            }
            else if (request()->has('returned_orders'))  {
                $data = $data->where('status', Constant::ORDER_STATUS['returned']);
            }
            else {
                $data = $data->where('status', Constant::ORDER_STATUS['pending']);
            }

            return DataTables::of($data)
                ->addColumn('sl', function ($row) {
                    return $this->dt_index($row);
                })
                ->addColumn('invoice_id', function ($row) {
                    if ($row->id) {
                        return '<a href="javascript:void(0);" onclick="invoiceView(' . $row->id . ')">' . adminFormatedInvoiceId($row->id) . '</a>';
                    } else {
                        return '---';
                    }
                })
                ->addColumn('username', function ($row) {
                    if ($row->user_id && $row->user->name) {
                        return '<a href="javascript:void(0);" onclick="userView(' . $row->user_id . ')"><i class="fa fa-user me-1"></i>' . e($row->user->name) . '</a>';
                    } else {
                        return '---';
                    }
                })
                ->addColumn('tracking_code', function ($row) {
                    if ($row->tracking_code) {
                        return '<a href="javascript:void(0)" onclick="copyToClipboard(\'' . e($row->tracking_code) . '\')" style="cursor: pointer;">' . e($row->tracking_code) . '<i class="fa fa-copy ms-2"></i></a>';
                    } else {
                        return '---';
                    }
                })
                ->addColumn('total_price', function ($row) {
                    if ($row->total_price) {
                        return country()->symbol . number_format2($row->total_price);
                    } else {
                        return '0';
                    }
                })
                ->addColumn('payment_method', function ($row) {
                    if ($row->payment_method) {
                        if($row->payment_method == Constant::PAYMENT_METHOD['cod']) {
                            return 'COD';
                        }else {
                            return $row->payment_method;
                        }
                    } else {
                        return '---';
                    }
                })
                ->addColumn('payment_status', function ($row) {
                    if ($row->payment_status) {
                        $paymentStatus = array_flip(Constant::PAYMENT_STATUS);

                        return $paymentStatus[$row->payment_status] ?? '---';

                    } else {
                        return '---';
                    }
                })
                ->addColumn('created_date', function ($row) {
                    if ($row->created_at) {
                        return $row->created_at->format('d-m-Y');
                    } else {
                        return '---';
                    }
                })
                ->addColumn('final_d_date', function ($row) {
                    if ($row->estimated_delivery_date) {
                        $estimatedDate = $row->estimated_delivery_date;

                        $createdDate = $row->created_at ? $row->created_at->startOfDay() : now()->startOfDay(); // Use created_at if available

                        if ($estimatedDate == Constant::ESTIMATED_TIME['within 24 hours']) {
                            return $createdDate->addHours(24)->format('d-m-Y'); // 24 hours later
                        } elseif ($estimatedDate == Constant::ESTIMATED_TIME['1 to 3 days']) {
                            return $createdDate->addDays(3)->format('d-m-Y'); // 3 days later
                        } elseif ($estimatedDate == Constant::ESTIMATED_TIME['3 to 7 days']) {
                            return $createdDate->addDays(7)->format('d-m-Y'); // 7 days later
                        }else {
                            return '---';
                        }

                    }
                })
                ->addColumn('status', function ($row) {
                    if ($row->status) {
                        $status = array_flip(Constant::ORDER_STATUS);

                        return '<span class="text-capitalize">' . $status[$row->status] . '</span>' ?? '---';

                    } else {
                        return '---';
                    }
                })
                ->addColumn('action', function ($row) {
                    $orderStatuses = Constant::ORDER_STATUS;

                    $dropdowns = '<div class="dropdown">
                    <button class="btn btn-outline-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Change Status
                    </button>
                    <ul class="dropdown-menu custom-dropdown-menu">';

                    foreach ($orderStatuses as $status => $value) {
                        $activeClass = ($row->status == $value) ? 'active' : '';
                        $dropdowns .= '<li><a class="dropdown-item  ' . $activeClass . '" href="javascript:void(0);" onclick="changeOrderStatus(' . $row->id . ', ' . $value . ')">' . $status . '</a></li>';
                    }

                    $dropdowns .= '</ul></div>';

                    return $dropdowns;
                })
                ->rawColumns(['sl', 'invoice_id', 'username', 'tracking_code', 'total_price', 'payment_method', 'payment_status', 'created_date', 'final_d_date', 'status', 'action'])
                ->make(true);
        }

        return view('admin.orders.orders', compact('pageTitle', 'breadcrumbs'));
    }

    public function singleUserView($id) {
        $modalTitle = "User Details";
        $user = User::with(['country','division', 'district', 'upazilas'])->find($id);
        $address = Address::where('user_id', $id)
                            ->where('status', Constant::STATUS['active'])
                            ->first();
        return response()->json([
            'view' => view('admin.orders.models.user_model_body', compact('user', 'address'))->render(),
            'modalTitle' => $modalTitle
        ]);
    }

    public function singleInvoiceView($id) {
        $modalTitle = "Order Details";
        $invoice = Invoice::find($id);
        $invoiceItem = InvoiceItem::where('invoice_id', $id)->get();
        $address = Address::where('id', $invoice->shipping_address_id)
                            ->first();
        $showPrintButton = true;
        return response()->json([
            'view' => view('admin.orders.models.invoice_body', compact('address', 'invoice', 'invoiceItem'))->render(),
            'modalTitle' => $modalTitle,
            'showPrintButton' => $showPrintButton
        ]);
    }

    public function updateStatus(Request $request, $id) {
        $order = Invoice::find($id);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Prevent updating to the same status
        if ($order->status == $request->status) {
            return response()->json('already_exist');
        }

        // Define allowed status transitions
        $validTransitions = [
            Constant::ORDER_STATUS['pending'] => [Constant::ORDER_STATUS['confirmed'], Constant::ORDER_STATUS['cancelled']],
            Constant::ORDER_STATUS['confirmed'] => [Constant::ORDER_STATUS['processing'], Constant::ORDER_STATUS['cancelled']],
            Constant::ORDER_STATUS['processing'] => [Constant::ORDER_STATUS['shipped'], Constant::ORDER_STATUS['cancelled']],
            Constant::ORDER_STATUS['shipped'] => [Constant::ORDER_STATUS['delivered']],
            Constant::ORDER_STATUS['delivered'] => [Constant::ORDER_STATUS['returned'], Constant::ORDER_STATUS['refunded']],
            Constant::ORDER_STATUS['cancelled'] => [],
            Constant::ORDER_STATUS['refunded'] => [],
            Constant::ORDER_STATUS['returned'] => [Constant::ORDER_STATUS['refunded']],
        ];

        // Check if the transition is valid
        if (!isset($validTransitions[$order->status]) || !in_array($request->status, $validTransitions[$order->status])) {
            return response()->json('invalid_transition');
        }

        // Update order status
        $order->status = $request->status;
        $order->save();

        return response()->json(['status' => array_search($request->status, Constant::ORDER_STATUS)]);
    }

}

