<?php

namespace App\Http\Controllers\Customer;

use App\Helpers\Constant;
use App\Helpers\Traits\RowIndex;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressStoreRequest;
use App\Models\Address;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Partnership;
use App\Models\PaymentMethod;
use Devfaysal\BangladeshGeocode\Models\Upazila;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AddressBookController extends Controller
{
    use RowIndex;
    public function index()
    {
        $pageTitle = 'Address Book';

        $categories       = Category::with('subcategories.products')->get();
        $paymentMethods   = PaymentMethod::orderBy('id', 'DESC')->get();
        $brands           = Brand::orderBy('id', 'ASC')->get();
        $partnerships     = Partnership::orderBy('id', 'ASC')->get();
        $user             = auth()->user();


        if (request()->ajax()) {
            // Fetch the user's addresses and optionally order them
            $data = $user->addresses()->orderBy('id', 'ASC')->get();

            return DataTables::of($data)
                ->addColumn('sl', function ($row) {
                    return $this->dt_index($row); // Assuming this method returns the serial number
                })
                ->addColumn('name', function ($row) {
                    return $row->name; // Display the full name
                })
                ->addColumn('address', function ($row) {
                    // Correct comparison for 'home' or 'office'
                    if ($row->delivery_place == Constant::DELIVERY_PLACE['home']) {
                        $place = '<span class="label label-success">Home</span>';
                    } else {
                        $place = '<span class="label label-primary">Office</span>';
                    }
                    return $place . ' ' .
                           ($row->address ?? '') . ' - ' .
                           ($row->upazilas->name ?? 'N/A') . ' - ' .
                           ($row->district->name ?? 'N/A') . ' - ' .
                           ($row->division->name ?? 'N/A');
                })
                ->addColumn('phone', function ($row) {
                    return $row->phone ?? '---'; // Phone number or a placeholder
                })->addColumn('is_default', function ($row) {
                    if ($row->is_default == Constant::DEFAULT_ADDRESS['both']) {
                        $html = '<p>Default Billing Address</p><p>Default Shipping Address</p>';
                    } else if ($row->is_default == Constant::DEFAULT_ADDRESS['billing']) {
                        $html = '<p>Default Billing Address</p>';
                    } else if ($row->is_default == Constant::DEFAULT_ADDRESS['shipping']) {
                        $html = '<p>Default Shipping Address</p>';
                    }
                    return $html ?? '';
                })
                ->addColumn('action', function ($row) {
                    // Action buttons for edit and delete
                    $btn1 = '<button onclick="edit(' . $row->id . ')" type="button" class="btn hide_show editBtn me-2 btn-sm btn-outline-success me-1 mb-2">Edit</button>';
                    $btn2 = '<button onclick="destroy(' . $row->id . ')" type="button" class="btn hide_show deleteBtn btn-sm btn-outline-danger mb-2">/ Delete</button>';

                    $input3 = '<input class="default_address_cl" id="'.$row->id.'" type="radio" name="default_address" value="'.$row->is_default.'" />';

                    return $btn1 . $btn2 . $input3;
                })
                ->rawColumns(['sl', 'address', 'is_default', 'action']) // Allow raw HTML for these columns
                ->make(true);
        }


        return view('customer.addressbook.index', [
            'pageTitle'            => $pageTitle,
            'categories'           => $categories,
            'paymentMethods'       => $paymentMethods,
            'brands'               => $brands,
            'partnerships'         => $partnerships,
            'user'                 => $user,

        ]);
    }


    public function store(AddressStoreRequest $request) {

        $userId = Auth()->user()->id;

        $data = new Address();

        $address = Address::where('user_id', $userId)->first();
        if(!$address) {
            $address_data = Constant::DEFAULT_ADDRESS['both'];
            $status = Constant::STATUS['active'];
        }else {
            $address_data = null;
            $status = null;
        }

        $data->user_id = $userId;
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->delivery_place = $request->place;
        $data->state = $request->division;
        $data->city = $request->district;
        $data->upazila = $request->upazila;
        $data->address = $request->address;
        $data->is_default = $address_data;
        $data->status = $status;
        $data->save();

        return response()->json();

    }

    public function edit($id) {
        $address = Address::find($id);
        return response()->json($address);
    }

    public function update(AddressStoreRequest $request, $id)
    {
        $address = Address::findOrFail($id);

        $address->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'delivery_place' => $request->input('place'),
            'state' => $request->input('division'),
            'city' => $request->input('district'),
            'upazila' => $request->input('upazila'),
            'address' => $request->input('address'),
        ]);

        return response()->json();
    }

    public function destroy($id) {
        $data = Address::find($id);
        $data->delete();
        return response()->json();
    }


    public function defaultAddress(Request $request, $id) {
        $request->validate([
            'default_address' => ['required'],
        ]);

        $current_address = Address::find($id);

        // Validate if address exists
        if (!$current_address) {
            return response()->json(['error' => 'Address not found.'], 404);
        }

        // Get values from constants
        $billing = Constant::DEFAULT_ADDRESS['billing'];
        $shipping = Constant::DEFAULT_ADDRESS['shipping'];
        $both = Constant::DEFAULT_ADDRESS['both'];
        $status = Constant::STATUS['active'];

        // Check if the request is to make it billing
        if ($request->default_address == $billing) {
            $existing_both_address = Address::where('is_default', $both)->first();

            if ($existing_both_address) {
                // Update existing both address to shipping
                $existing_both_address->is_default = $shipping;
                $existing_both_address->status = $status;
                $existing_both_address->save();

                // Set current address to billing
                $current_address->is_default = $billing;
                $current_address->status = null;
                $current_address->save();

                return response()->json(['message' => 'Default Billing Address Set Successfully.']);
            }

            if($current_address->is_default == $billing) {
                return response()->json(['message' => 'Already set as Default Billing Address.']);
            }
            if($current_address->is_default == $shipping)  {
                // Set current address to both and remove the other billing address
                $existing_billing_address = Address::where('is_default', $billing)->first();
                if ($existing_billing_address) {
                    $existing_billing_address->is_default = null;
                    $existing_billing_address->status = null;
                    $existing_billing_address->save();
                }
                $current_address->is_default = $both;
                $current_address->status = $status;
                $current_address->save();
                return response()->json(['message' => 'Default Billing Address Set Successfully.']);
            }

        }

        // Check if the request is to make it shipping
        if ($request->default_address == $shipping) {
            $existing_both_address = Address::where('is_default', $both)->first();

            if ($existing_both_address) {
                // Update existing both address to shipping
                $existing_both_address->is_default = $billing;
                $existing_both_address->status = null;
                $existing_both_address->save();

                // Set current address to shipping
                $current_address->is_default = $shipping;
                $current_address->status = $status;
                $current_address->save();

                return response()->json(['message' => 'Default Shipping Address Set Successfully.']);
            }

            if($current_address->is_default == $shipping) {
                return response()->json(['message' => 'Already set as Default Shipping Address.']);
            }

            if($current_address->is_default == $billing)  {
                // Set current address to both and remove the other billing address
                $existing_shipping_address = Address::where('is_default', $shipping)->first();
                if ($existing_shipping_address) {
                    $existing_shipping_address->is_default = null;
                    $existing_shipping_address->status = null;
                    $existing_shipping_address->save();
                }
                $current_address->is_default = $both;
                $current_address->status = $status;
                $current_address->save();
                return response()->json(['message' => 'Default Shipping Address Set Successfully.']);
            }
        }

        // If neither billing nor shipping was selected
        return response()->json(['error' => 'Invalid address type.'], 422);
    }



}
