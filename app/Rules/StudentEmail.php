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
        // ^ Start of string
        // [a-z] Initial of the student's first name
        // \.[a-z]* Dot followed Student's last name
        // \.\d{6} Dot followed by Student's ID (6 digits)
        // (\.tc)? Student's school if .tc is present then, it is in um tagum branch else it is um main branch
        // @umindanao\.edu\.ph email domain
        // $ End of string
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
