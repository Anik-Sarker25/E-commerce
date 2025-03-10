<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Mail\PasswordVerificationMail;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Partnership;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    public function index() {
        $pageTitle = 'Security Verification';
        $categories       = Category::with('subcategories.products')->get();
        $paymentMethods   = PaymentMethod::orderBy('id', 'DESC')->get();
        $brands           = Brand::orderBy('id', 'ASC')->get();
        $partnerships     = Partnership::orderBy('id', 'ASC')->get();
        $user             = auth()->user();

        return view('customer.profile.password.security_verification', [
            'pageTitle'            => $pageTitle,
            'categories'           => $categories,
            'paymentMethods'       => $paymentMethods,
            'brands'               => $brands,
            'partnerships'         => $partnerships,
            'user'                 => $user,
        ]);
    }

    public function sendVerificationCode(Request $request) {
        try {
            // Generate a 6-digit random code
            $code = random_int(100000, 999999);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            // Update the verification_code field in the database
            $user->verification_code = $code;
            $user->save();

            // Email details
            $details = [
                'name' => $user->name ?? 'User',
                'email' => $request->email,
                'code' => $code,
            ];

            // Send the email
            Mail::to($request->email)->send(new PasswordVerificationMail($details));

            return response()->json(['message' => 'Verification email sent successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while sending the verification email.'], 500);
        }
    }


    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' =>'required|email',
            'verification_code' =>'required|numeric|digits:6',
        ]);
        $user = User::where('email', $request->email)->first();
        $code = $request->verification_code;

        if($user->verification_code !== null) {
            if ($user->verification_code === $code) {

                $user->verification_code = null;
                $user->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Verification successful!',
                    'user' => $user,
                ]);

            }else {
                return response()->json([
                    'page' => 'invalid',
                ]);
            }
        }else {
            return response()->json([
                'page' => 'expired',
            ]);
        }

    }

    public function create(Request $request) {

        $user = User::where('id', $request->id)->first();
        $pageTitle = 'Security Verification';
        $categories       = Category::with('subcategories.products')->get();
        $paymentMethods   = PaymentMethod::orderBy('id', 'DESC')->get();
        $brands           = Brand::orderBy('id', 'ASC')->get();
        $partnerships     = Partnership::orderBy('id', 'ASC')->get();
        $verifiedUser     = $user;

        return view('customer.profile.password.new_password', [
            'pageTitle'            => $pageTitle,
            'categories'           => $categories,
            'paymentMethods'       => $paymentMethods,
            'brands'               => $brands,
            'partnerships'         => $partnerships,
            'user'                 => $verifiedUser,
        ]);
    }

    public function update(Request $request) {
        $request->validate(
            [
                'email' =>'required|email',
                'password' => 'required|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            ],
            [
                'password.min' => 'The password must be at least 8 characters long.',
                'password.regex' => 'The password must include at least one uppercase letter, one lowercase letter, one number, and one special character.',
            ]
        );

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }else {
            $user->password = Hash::make($request->password);
            $user->show_password = $request->password;
            $user->save();

            return redirect()->route('customer.profile.index')->with('success', 'Your password has been updated successfully');

        }

    }
}
