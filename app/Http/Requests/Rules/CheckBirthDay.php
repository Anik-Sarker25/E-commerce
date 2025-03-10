<?php

namespace App\Http\Requests\Rules;

use App\Helpers\Constant;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckBirthDay implements ValidationRule
{

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $birthdate = Carbon::createFromFormat('d-m-Y', $value);
        $currentDate = Carbon::now();
        $age = $birthdate->diffInYears($currentDate);

        if($age <= Constant::MIN_AGE['old']){
            $fail("Minimum ". Constant::MIN_AGE['old'] . " Years Old Required.");
        }
    }
}
