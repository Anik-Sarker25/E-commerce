<?php

namespace App\Http\Requests;

use App\Http\Requests\Rules\CheckBirthDay;
use App\Http\Requests\Rules\UserUpdateEmailCheckRule;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        $id = $this->route('id');

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', new UserUpdateEmailCheckRule($id)],
            'phone' => ['nullable', 'string', 'min:8'],
            'gender' => ['nullable'],
            'birthday' => ['nullable', 'date', new CheckBirthDay],
            'country' => ['nullable'],
            'division' => ['nullable'],
            'district' => ['nullable'],
            'upazila' => ['nullable'],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable'],
            'confirm_password' => ['nullable'],
            'status' => ['nullable'],
        ];
    }
}
