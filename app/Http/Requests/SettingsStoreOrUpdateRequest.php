<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsStoreOrUpdateRequest extends FormRequest
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
            'company_name' => ['nullable', 'string', 'max:255'],
            'company_motto' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:15'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'map' => ['nullable', 'url', 'max:1000'],
            'timezone' => ['nullable', 'string', 'max:100'],
            'system_name' => ['nullable', 'string', 'max:100'],
            'logo' => $this->hasFile('logo') ? ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'] : ['nullable'],
            'favicon' => $this->hasFile('favicon') ? ['nullable', 'image', 'mimes:ico,png'] : ['nullable'],
            'admin_logo' => $this->hasFile('admin_logo') ? ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'] : ['nullable'],
            'copyright' => ['nullable', 'string', 'max:255'],
            'site_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'about_company' => ['nullable', 'string', 'max:2000'],
            'meta_image' => $this->hasFile('meta_image') ? ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'] : ['nullable'],
        ];
    }
}
