<?php

namespace App\Http\Requests\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserUpdateEmailCheckRule implements ValidationRule
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
        $existingUser = User::where('email', $value)
            ->where('id', '!=', $this->id)  // Exclude the provided user ID
            ->exists();

        if ($existingUser) {
            // If the email is already taken by another user, fail the validation
            $fail('The email is already taken by another user.');
        }
    }
}
