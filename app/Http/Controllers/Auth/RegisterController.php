<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Constant;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/customer/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email_address' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'account_password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    // protected function create(array $data)
    // {
    //     return User::create([
    //         'name' => $data['name'],
    //         'email' => $data['email_address'],
    //         'password' => Hash::make($data['account_password']),
    //         'show_password' =>$data['account_password'],
    //         'role' => Constant::USER_TYPE['customer'],
    //     ]);
    // }
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email_address'],
            'password' => Hash::make($data['account_password']),
            'show_password' => $data['account_password'],
            'role' => Constant::USER_TYPE['customer'],
            'status' => Constant::USER_STATUS['active'],
        ]);

        return $user;
    }
}
