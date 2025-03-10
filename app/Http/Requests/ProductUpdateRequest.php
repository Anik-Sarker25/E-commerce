<?php

namespace App\Http\Requests;

use App\Http\Requests\Rules\ThumbnailCheckRule;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'buy_price' => ['required', 'numeric'],
            'mrp_price' => ['required', 'numeric'],
            'discount_price' => ['required', 'numeric', 'lt:buy_price'], // Discount must be less than buy price
            'sell_price' => ['required', 'numeric', 'gte:buy_price'], // Sell price must be greater than or equal to buy price
            'category_id' => ['required', 'integer'],
            'subcategory_id' => ['nullable'],
            'childcategory_id' => ['nullable', 'integer'],
            'brand_id' => ['nullable', 'integer'],
            'model_no' => ['nullable', 'string', 'max:255'],
            'keywords' => ['nullable', 'string', 'max:255'],
            'sizes.*' => ['nullable', 'string', 'max:255'],
            'colors.*' => ['nullable', 'string', 'max:255'],
            'condition' => ['nullable', 'string', 'max:255'],
            'thumbnail' => $this->hasFile('thumbnail') ? ['image', 'mimes:jpeg,png,jpg'] : ['nullable', new ThumbnailCheckRule($id)],
            'featured_images.*' => $this->hasFile('featured_images') ? ['image', 'mimes:jpeg,png,jpg'] : ['nullable'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description' => [
                'required',
                'string',
                'regex:/^(?!<p>\s*<\/p>|<br>\s*<\/br>|<p><br><\/p>|<\/br>|<b>\s*<\/b>|<i>\s*<\/i>)(.*)$/',
            ],
            'product_type' => ['nullable', 'string'],
            'deals_time' => ['nullable', 'date'],
            'stock' => ['nullable', 'numeric'],
            'product_return' => ['required'],
            'warranty' => ['required'],
            'unit' => ['required'],
            'delivery_type' => ['required'],
            'status' => ['required'],
        ];

    }
    public function messages()
    {
        return [
            'description.regex' => 'The description field is required.'
        ];
    }
}
