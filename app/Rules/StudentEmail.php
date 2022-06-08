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
        $username = explode('@', $value)[0];

        return $this->isValidDomain($value) && $this->isValidUsername($username);
    }

    private function isValidDomain($value)
    {
        return str($value)->endsWith('@umindanao.edu.ph');
    }

    private function isValidUsername($username)
    {
        list($initialName, $lastName, $studentId, $postfix) = explode('.', $username);

        return strlen($initialName) == 1
            && strlen($lastName) > 0
            && (strlen($studentId) == 6 && ctype_digit($studentId))
            && $postfix == 'tc';
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
