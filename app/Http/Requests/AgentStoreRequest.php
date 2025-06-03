<?php

namespace App\Http\Requests;

use App\Http\Requests\Rules\CheckBirthDay;
use Illuminate\Foundation\Http\FormRequest;

class AgentStoreRequest extends FormRequest
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
            'phone_number' => ['required', 'string', 'max:20'],
            'vehicle_number' => ['required', 'string', 'min:8', 'max:255'],
            'image' => $this->hasFile('image') ? ['image', 'mimes:jpeg,png,jpg'] : ['nullable'],
            'nid_number' => ['nullable', 'string', 'max:30'],
            'blood_group' => ['nullable', 'string', 'max:10'],
            'address' => ['nullable', 'string', 'max:500'],
            'marital_status' => ['nullable'],
            'birthday' => ['nullable', 'date', new CheckBirthDay],
            'status' => ['nullable'],
            'engage_status' => ['nullable', 'string', 'max:50'],
        ];
    }

}
