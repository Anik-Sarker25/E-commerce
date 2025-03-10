<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Partnership;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerProfileController extends Controller
{
    public function index() {
        if(request()->has('edit')) {
            $pageTitle = 'Edit Profile';
        }else {
            $pageTitle = 'My Profile';
        }
        $categories       = Category::with('subcategories.products')->get();
        $paymentMethods   = PaymentMethod::orderBy('id', 'DESC')->get();
        $brands           = Brand::orderBy('id', 'ASC')->get();
        $partnerships     = Partnership::orderBy('id', 'ASC')->get();
        $user             = auth()->user();

        return view('customer.profile.profile', [
            'pageTitle'            => $pageTitle,
            'categories'           => $categories,
            'paymentMethods'       => $paymentMethods,
            'brands'               => $brands,
            'partnerships'         => $partnerships,
            'user'                 => $user,
        ]);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        try {
            // update user
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->gender = $request->gender;
            $user->birthday = strtotime($request->birthday);
            $user->save();

            $birthday = dateFormat($user->birthday);

            return response()->json([$user, $birthday]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
