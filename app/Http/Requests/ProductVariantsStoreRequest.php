<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductVariantsStoreRequest extends FormRequest
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
            'product_id' => ['required', 'string', 'max:255'],
            'color_family' => ['nullable', 'string'],
            'variant_type' => ['nullable', 'string'],
            'variant_value' => ['nullable', 'string'],
            'buy_price' => ['required', 'numeric'],
            'mrp_price' => ['required', 'numeric'],
            'discount_price' => ['required', 'numeric', 'lt:buy_price'], // Discount must be less than buy price
            'sell_price' => ['required', 'numeric', 'gte:buy_price'], // Sell price must be greater than or equal to buy price
            'stock' => ['required', 'integer', 'min:0'],
        ];

    }

    protected function prepareForValidation()
    {
        $this->merge([
            'variant_type' => $this->variant_type === 'null' ? null : $this->variant_type,
            'variant_value' => $this->variant_value === 'null' ? null : $this->variant_value,
        ]);
    }

}
