<?php

namespace App\Http\Controllers\User;

use App\Helpers\Constant;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Partnership;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    public function index() {
        $pageTitle = 'Checkout';

        $categories       = Category::with('subcategories.products')->get();
        $paymentMethods   = PaymentMethod::orderBy('id', 'DESC')->get();
        $brands           = Brand::orderBy('id', 'ASC')->get();
        $partnerships     = Partnership::orderBy('id', 'ASC')->get();

        $breadcrumbs = [
            ['url' => route('home'), 'title' => 'home'],
            ['url' => route('checkout.index'), 'title' => 'checkout'],
        ];


        $address = null;
        $addresses = []; // null array for guest users


        if (auth()->check()) {
            $address = Address::where('user_id', auth()->user()->id)
                ->where('status', Constant::STATUS['active'])
                ->first();

            $addresses = Address::where('user_id', auth()->user()->id)->get();
        }
        return view('customer.checkout.checkout', [
            'address'              => $address,
            'addresses'            => $addresses,
            'pageTitle'            => $pageTitle,
            'categories'           => $categories,
            'paymentMethods'       => $paymentMethods,
            'brands'               => $brands,
            'partnerships'         => $partnerships,
            'breadcrumbs'          => $breadcrumbs,
        ]);
    }




    public function changeStatus($id) {
        $data = Address::findOrFail($id);

        if ($data->status === Constant::STATUS['active'] || $data->status !== null) {
            return response()->json('already_exist');
        } else {
            // Deactivate all other addresses of the user
            Address::where('user_id', auth()->id())
                ->where('id', '!=', $id)
                ->update(['status' => null]);

            // Activate the selected address
            $data->status = Constant::STATUS['active'];
            $data->save();

            return response()->json('success');
        }

    }
    public function getSelectedAddress() {
        $address = Address::where('user_id', auth()->id())
                         ->where('status', Constant::STATUS['active'])
                         ->first();
        return view('customer.checkout.components.address', compact('address'));
    }



}



