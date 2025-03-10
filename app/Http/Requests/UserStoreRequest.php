<?php

namespace App\Http\Requests;

use App\Http\Requests\Rules\CheckBirthDay;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'min:8'],
            'gender' => ['nullable'],
            'birthday' => ['nullable', 'date', new CheckBirthDay],
            'country' => ['nullable'],
            'division' => ['nullable'],
            'district' => ['nullable'],
            'upazila' => ['nullable'],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['required_with:password', 'same:password'],
            'status' => ['nullable'],
        ];
    }
}
