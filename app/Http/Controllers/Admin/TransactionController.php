<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Constant;
use App\Helpers\Traits\RowIndex;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    use RowIndex;
    public function index() {

        $pageTitle = 'all transactions';
        $breadcrumbs = [
            ['url' => route('admin.transactions.index'), 'title' => 'all users'],
        ];

        if (request()->ajax()) {
            
            $transactions = Transaction::orderBy('id', 'DESC')->get();

            return DataTables::of($transactions)
                ->addColumn('sl', function ($row) {
                    return $this->dt_index($row); // this method generates the index
                })
                ->addColumn('user_id', function ($row) {
                    if($row->user_id) {
                        $user = $row->user->name;
                    }else {
                        $user = '----';
                    }
                    return $user;
                })
                ->addColumn('order_id', function ($row) {
                    if ($row->order_id) {
                        return adminFormatedInvoiceId($row->order_id);
                    } else {
                        return '---';
                    }
                })
                ->addColumn('amount', function ($row) {
                    if ($row->amount) {
                        return country()->symbol . number_format2($row->amount);
                    } else {
                        return '0';
                    }
                })
                ->addColumn('payment_method', function ($row) {
                    if ($row->payment_method) {
                        if($row->payment_method == Constant::PAYMENT_METHOD['cod']) {
                            return 'Cash On Delivery';
                        }else {
                            return $row->payment_method;
                        }
                    } else {
                        return '---';
                    }
                })
                ->addColumn('transaction_type', function ($row) {
                    if ($row->transaction_type) {
                        $transaction_type = array_flip(Constant::TRANSACTION_TYPE);

                        return $transaction_type[$row->transaction_type] ?? '---';

                    } else {
                        return '---';
                    }
                    return $status;
                })
                ->addColumn('transaction_status', function ($row) {
                    if($row->transaction_status) {
                        $status = '<span class="text-capitalize">'. $row->transaction_status . '</span>';
                    }else {
                        $status = '---';
                    }
                    return $status;
                })
                ->addColumn('date', function ($row) {
                    $date = date_format($row->created_at, 'd M Y');
                   
                    return $date;
                })
                ->addColumn('action', function ($row) {
                    $btn1 = '<button onclick="destroy(' . $row->id . ')" type="button" class="btn btn-sm btn-outline-danger mb-2"><i class="fas fa-trash-alt me-2"></i>Delete</button>';
                    return $btn1;
                })
                ->rawColumns(['sl', 'payment_method', 'transaction_type', 'transaction_status', 'date', 'action'])
                ->make(true);
        }

        return view('admin.transactions.transactions', compact('pageTitle', 'breadcrumbs'));
    }

    public function destroy($id){
        $data = Transaction::findOrFail($id);
        if($data == true){
            $data->delete();
        }
        return response()->json();
    }

}
