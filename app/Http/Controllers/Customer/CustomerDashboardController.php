<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Partnership;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class CustomerDashboardController extends Controller
{
    public function index() {
        $pageTitle = 'Manage my account';
        $categories       = Category::with('subcategories.products')->get();
        $paymentMethods   = PaymentMethod::orderBy('id', 'DESC')->get();
        $brands           = Brand::orderBy('id', 'ASC')->get();
        $partnerships     = Partnership::orderBy('id', 'ASC')->get();
        $user             = auth()->user();
        $invoices         = Invoice::where('user_id', auth()->id())->latest()->take(3)->get();
        $invoiceItems     = InvoiceItem::whereIn('invoice_id', $invoices->pluck('id'))->get();


        return view('customer.dashboard', [
            'pageTitle'            => $pageTitle,
            'categories'           => $categories,
            'paymentMethods'       => $paymentMethods,
            'brands'               => $brands,
            'partnerships'         => $partnerships,
            'user'                 => $user,
            'invoices'             => $invoices,
            'invoiceItems'         => $invoiceItems,
        ]);
    }
}
