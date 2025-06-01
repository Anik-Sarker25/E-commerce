<?php

namespace App\Http\Controllers\Customer;

use App\Helpers\Constant;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\DeliveryOption;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Partnership;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{
    public function index() {
        $pageTitle = 'My Orders';
        $categories       = Category::with('subcategories.products')->get();
        $paymentMethods   = PaymentMethod::orderBy('id', 'DESC')->get();
        $brands           = Brand::orderBy('id', 'ASC')->get();
        $partnerships     = Partnership::orderBy('id', 'ASC')->get();
        $user             = auth()->user();
        $invoices         = Invoice::where('user_id', auth()->id())->orderBy('id', 'DESC')->get();


        return view('customer.orders.orders', [
            'pageTitle'            => $pageTitle,
            'categories'           => $categories,
            'paymentMethods'       => $paymentMethods,
            'brands'               => $brands,
            'partnerships'         => $partnerships,
            'user'                 => $user,
            'invoices'             => $invoices,
        ]);
    }

    public function invoiceView(Request $request) {
        $id = $request->query('tradeOrderId');
        $pageTitle        = 'Order Details';
        $categories       = Category::with('subcategories.products')->get();
        $paymentMethods   = PaymentMethod::orderBy('id', 'DESC')->get();
        $brands           = Brand::orderBy('id', 'ASC')->get();
        $partnerships     = Partnership::orderBy('id', 'ASC')->get();
        $user             = auth()->user();
        $invoice          = Invoice::find($id);
        $addressId        = $invoice->shipping_address_id;
        $address          = Address::find($addressId);

        return view('customer.orders.order_view', [
            'pageTitle'            => $pageTitle,
            'categories'           => $categories,
            'paymentMethods'       => $paymentMethods,
            'brands'               => $brands,
            'partnerships'         => $partnerships,
            'user'                 => $user,
            'invoice'              => $invoice,
            'address'              => $address,
        ]);

    }

    public function trackPackage(Request $request) {
        // $id = $request->query('TrkOrdErId');
        $pageTitle        = 'Tracking Details';
        $categories       = Category::with('subcategories.products')->get();
        $paymentMethods   = PaymentMethod::orderBy('id', 'DESC')->get();
        $brands           = Brand::orderBy('id', 'ASC')->get();
        $partnerships     = Partnership::orderBy('id', 'ASC')->get();
        $user             = auth()->user();
        // $invoice          = Invoice::find($id);

        return view('customer.orders.track_package', [
            'pageTitle'            => $pageTitle,
            'categories'           => $categories,
            'paymentMethods'       => $paymentMethods,
            'brands'               => $brands,
            'partnerships'         => $partnerships,
            'user'                 => $user,
            // 'invoice'              => $invoice,
        ]);

    }

    public function trackCancelation(Request $request) {
        $id = $request->query('TrkOrdErId');
        $pageTitle        = 'Tracking Details';
        $categories       = Category::with('subcategories.products')->get();
        $paymentMethods   = PaymentMethod::orderBy('id', 'DESC')->get();
        $brands           = Brand::orderBy('id', 'ASC')->get();
        $partnerships     = Partnership::orderBy('id', 'ASC')->get();
        $user             = auth()->user();
        $invoice          = Invoice::find($id);

        return view('customer.orders.cancelation_track', [
            'pageTitle'            => $pageTitle,
            'categories'           => $categories,
            'paymentMethods'       => $paymentMethods,
            'brands'               => $brands,
            'partnerships'         => $partnerships,
            'user'                 => $user,
            'invoice'              => $invoice,
        ]);

    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'shipping_id' => 'required|string|max:100',
            'payment_method' => 'required|string|max:100',
            'shipping_fee' => 'required|string|max:100',
        ]);

        $buyNowItem = session('buy_now_item');
    
        DB::beginTransaction();

        try {
            $deliveryData = is_numeric($request->delivery_type)
                ? DeliveryOption::find($request->delivery_type)
                : null;

            $shippingFee = $deliveryData?->cost ?? (float)$request->shipping_fee;

            //  BUY NOW FLOW
            if (!empty($buyNowItem)) {
                $ItemPrice = $buyNowItem['price'];
                $quantity = $request->buy_quantity ?? $buyNowItem['quantity'];
                $totalItemPrice = $ItemPrice * $quantity;

                $totalPrice = $totalItemPrice + $shippingFee;

                $invoice = Invoice::create([
                    'user_id' => auth()->id() ?? null,
                    'customer_name' => $request->name,
                    'customer_email' => $request->email,
                    'customer_phone' => $request->phone,
                    'shipping_address_id' => $request->shipping_id,
                    'price' => $totalItemPrice,
                    'shipping_cost' => $shippingFee,
                    'total_price' => $totalPrice,
                    'payment_method' => $request->payment_method,
                    'payment_status' => Constant::PAYMENT_STATUS['unpaid'],
                    'delivery_type' => $request->delivery_type,
                    'estimated_delivery_date' => $request->estimated_delivery_date,
                    'status' => Constant::ORDER_STATUS['pending'],
                ]);

                $trackingCode = 'TRK-' . strtoupper(Str::random(6)) . '-' . $invoice->id . $invoice->created_at->format('Ymd');
                $invoice->update(['tracking_code' => $trackingCode]);

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $buyNowItem['product_id'],
                    'product_name' => $buyNowItem['product_name'],
                    'color_id' => $buyNowItem['color'] ?? null,
                    'size_id' => $buyNowItem['size'] ?? null,
                    'price' => $buyNowItem['price'],
                    'total_price' => $totalItemPrice,
                    'quantity' => $quantity,
                ]);

                //  Forget Buy Now session
                session()->forget('buy_now_item');

                DB::commit();
                $formattedInvoiceId = customerFormatedInvoiceId($invoice->id);
                return response()->json([
                    'status' => 'success',
                    'buyProduct' => true,
                    'message' => 'Invoice (Buy Now) generated successfully!',
                    'invoice_id' => $formattedInvoiceId,
                ]);
            }else {
                //  CART FLOW
                $cartItems = Cart::where('user_id', auth()->id())->get();
                if ($cartItems->isEmpty()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No items found in cart.',
                    ]);
                }
        
                $totalItemPrice = $cartItems->sum('total_price');
                $totalPrice = $totalItemPrice + $shippingFee;
        
                $invoice = Invoice::create([
                    'user_id' => auth()->id() ?? null,
                    'customer_name' => $request->name,
                    'customer_email' => $request->email,
                    'customer_phone' => $request->phone,
                    'shipping_address_id' => $request->shipping_id,
                    'price' => $totalItemPrice,
                    'shipping_cost' => $shippingFee,
                    'total_price' => $totalPrice,
                    'payment_method' => $request->payment_method,
                    'payment_status' => Constant::PAYMENT_STATUS['unpaid'],
                    'delivery_type' => $request->delivery_type,
                    'estimated_delivery_date' => $request->estimated_delivery_date,
                    'status' => Constant::ORDER_STATUS['pending'],
                ]);
        
                $trackingCode = 'TRK-' . strtoupper(Str::random(6)) . '-' . $invoice->id . $invoice->created_at->format('Ymd');
                $invoice->update(['tracking_code' => $trackingCode]);
        
                foreach ($cartItems as $item) {
                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'color_id' => $item->color_id,
                        'size_id' => $item->size_id,
                        'price' => $item->price,
                        'total_price' => $item->total_price,
                        'quantity' => $item->quantity,
                    ]);
                }
        
                //  Clear cart
                if (auth()->check()) {
                    $userId = auth()->id();
                    $sessionId = session()->getId();
        
                    // Delete expired session-based cart items while keeping valid ones
                    Cart::where('user_id', $userId)
                        ->orWhere(function ($query) use ($sessionId) {
                            $query->where('session_id', '!=', $sessionId)
                                ->where('created_at', '<', now()->subHours(2)); // Adjust expiry time as needed
                        })->delete();
                } else {
                    // Delete only guest cart items for the current session for the future system
                    Cart::where('session_id', session()->getId())->delete();
                }
        
                DB::commit();
        
                $formattedInvoiceId = customerFormatedInvoiceId($invoice->id);
                return response()->json([
                    'status' => 'success',
                    'buyProduct' => false,
                    'message' => 'Invoice (Cart) generated successfully!',
                    'invoice_id' => $formattedInvoiceId,
                ]);

            }


        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Invoice Store Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the order. Please try again.',
            ]);
        }
    }


}
