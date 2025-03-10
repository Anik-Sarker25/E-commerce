<?php

namespace App\Http\Requests\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ThumbnailCheckRule implements ValidationRule
{
    protected int $id;
    public function __construct(int $id)
    {
        $this->id = $id;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $product = Product::find($this->id);
        if (!$product->thumbnail) {
            if ($value == 'undefined') {
                $fail('The thumbnail image is required.');
            }
        }

    }
}
