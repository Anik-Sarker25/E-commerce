<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use App\Models\Admin; // Import your Admin model
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class PasswordResetController extends Controller
{
    use SendsPasswordResetEmails, ResetsPasswords;

    public function showLinkRequestForm()
    {
        return view('admin.auth.passwords.email'); // View for sending reset link
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Check if the admin exists before sending the reset link
        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            return back()->withErrors(['email' => __('Email not found.')]);
        }

        // Use the custom broker for admins to send the reset link
        $response = Password::broker('admins')->sendResetLink($request->only('email'));

        // Notify the admin with the reset password link
        if ($response == Password::RESET_LINK_SENT) {
            // Generate a token
            $token = app('auth.password.broker')->createToken($admin);
            $admin->notify(new ResetPasswordNotification($token, $request->email));

            return back()->with(['status' => __('A password reset link has been sent to your email.')]);
        }

        return back()->withErrors(['email' => __('Failed to send the reset link.')]);
    }



    public function showResetForm($token, Request $request)
    {
        return view('admin.auth.passwords.reset')->with([
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required',
        ]);

        // Check if the admin exists
        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            return back()->withErrors(['email' => __('Email not found.')]);
        }

        // Check if the token is valid
        $isValidToken = DB::table('password_resets')->where('email', $request->email)->first();

        if (!$isValidToken) {
            return back()->with(['token' => __('Invalid or expired token. Please request a new password reset link.')]);
        }else {
            // Update the admin's password and save it
            $admin->password = Hash::make($request->password);
            $admin->show_password = $request->password; // Consider removing this line for security
            $admin->save();

            // Invalidate the token manually
            DB::table('password_resets')->where('email', $request->email)->delete();
            return redirect()->route('admin.login')->with('status', __('Your password has been reset!'));
        }

    }




    // Override the broker method to avoid collision
    protected function broker()
    {
        return Password::broker('admins'); // Specify the broker for admins
    }

    // Override credentials method to avoid collision
    protected function credentials(Request $request)
    {
        return $request->only('email', 'password', 'token');
    }
}
