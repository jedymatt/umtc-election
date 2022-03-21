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
        if (!str_contains($value, '@')) return false;

        list($username, $domain) = explode('@', $value);

        if ($domain != 'umindanao.edu.ph') return false;

        $usernameParts = explode('.', $username);

        if (count($usernameParts) != 4) return false;

        list($initialGivenName,
            $surname,
            $studentId,
            $postfix) = $usernameParts;

        if (strlen($initialGivenName) != 1
            || strlen($studentId) != 6
            || $postfix != 'tc') return false;

        if (!ctype_digit($studentId)) return false;

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
