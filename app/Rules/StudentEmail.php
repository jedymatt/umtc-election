<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ImplicitRule;
use Illuminate\Contracts\Validation\Rule;

class StudentEmail implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!str_contains($value, '@')) {
            return false;
        }

        list($username, $domain) = explode('@', $value);

        if ($domain != 'umindanao.edu.ph') {
            return false;
        }

        $parsedUsername = explode('.', $username);

        if (count($parsedUsername) != 4) {
            return false;
        }

        $initialGivenName = $parsedUsername[0];
        $studentId = $parsedUsername[2];

        if (strlen($initialGivenName) != 1) {
            return false;
        }

        if (strlen($studentId) != 6 || !ctype_digit($studentId)) {
            return false;
        }

        $postfix = $parsedUsername[3];

        if ($postfix != 'tc') {
            return false;
        }

        return true;
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
