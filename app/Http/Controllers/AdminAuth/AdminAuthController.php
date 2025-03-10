<?php

namespace App\Http\Controllers\AdminAuth;

use App\Helpers\Constant;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login'); // Create this view for the admin login form
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && $admin->status == Constant::USER_STATUS['active']) {
            if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
                // genarate session

                return redirect()->intended('/admin/dashboard');
            }
        }else {
            return back()->withErrors(['email' => 'Your Account is inactive'])->onlyInput('email');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        Cookie::queue(Cookie::forget('admin_session'));
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    public function showRegistrationForm() {
        return view('admin.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'show_password' => $request->password,
            'role' => Constant::USER_TYPE['author'],
            'status' => Constant::USER_STATUS['deactive'],
        ]);

        return redirect()->route('admin.login')->with('info', 'Your Author registration has been waiting for admin approval');
    }
}
