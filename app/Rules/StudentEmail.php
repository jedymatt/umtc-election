<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StudentEmail implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^[a-z]\.[a-z]*\.\d{6}(\.tc)?@umindanao\.edu\.ph$/', $value) === 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a student email address.';
    }
}
