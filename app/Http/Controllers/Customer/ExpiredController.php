<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpiredController extends Controller
{
    public function index() {
        $pageTitle = 'Code Expaired';
        return view('customer.profile.password.incorrect', compact('pageTitle'));
    }

    public function invalidCode() {
        $pageTitle = 'Invalid verification code.';
        return view('customer.profile.password.incorrect', compact('pageTitle'));
    }
}
