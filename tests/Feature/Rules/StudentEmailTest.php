<?php

namespace Rules;

use App\Rules\StudentEmail;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class StudentEmailTest extends TestCase
{
    public function test_no_initial()
    {
        $this->assertFalse(
            (new StudentEmail)
                ->passes(
                    'email',
                    'lastname.123456.tc@umindanao.edu.ph'
                )
        );
    }

    public function test_no_domain()
    {
        $this->assertFalse(
            (new StudentEmail)
                ->passes(
                    'email',
                    'f.lastname.123456.tc@'
                )
        );
    }

    public function test_no_username()
    {
        $this->assertFalse(
            (new StudentEmail)
                ->passes(
                    'email',
                    '@umindanao.edu.ph'
                )
        );
    }

    public function test_initial_extra_character()
    {
        $this->assertFalse(
            (new StudentEmail)
                ->passes(
                    'email',
                    'fextracharacter.lastname.123456.tc@umindanao.edu.ph'
                )
        );
    }

    public function test_not_institutional_domain()
    {
        $this->assertFalse(
            (new StudentEmail)
                ->passes(
                    'email',
                    'fs.lastname.123456.tc@gmail.com'
                )
        );
    }

    public function test_not_email()
    {
        $this->assertFalse(
            (new StudentEmail)
                ->passes(
                    'email',
                    Str::random(),
                )
        );
    }

    public function test_no_tc_postfix_in_username()
    {
        $this->assertFalse(
            (new StudentEmail)
                ->passes(
                    'email',
                    'f.lastname.123456@umindanao.edu.ph'
                )
        );
    }

    public function test_postfix_not_tc()
    {
        $this->assertFalse(
            (new StudentEmail)
                ->passes(
                    'email',
                    'f.lastname.123456.nottc@umindanao.edu.ph'
                )
        );
    }

    public function test_student_id_contains_letter()
    {
        $this->assertFalse(
            (new StudentEmail)
                ->passes(
                    'email',
                    'f.lastname.12A456.tc@umindanao.edu.ph'
                )
        );
    }

    public function test_student_id_extra_length()
    {
        $this->assertFalse(
            (new StudentEmail)
                ->passes(
                    'email',
                    'f.lastname.1234567.tc@umindanao.edu.ph'
                )
        );
    }

    public function test_student_id_lesser_length()
    {
        $this->assertFalse(
            (new StudentEmail)
                ->passes(
                    'email',
                    'f.lastname.12345.tc@umindanao.edu.ph'
                )
        );
    }

    public function test_valid_email()
    {
        $this->assertTrue(
            (new StudentEmail)
                ->passes(
                    'email',
                    'f.lastname.123456.tc@umindanao.edu.ph'
                )
        );
    }
}
