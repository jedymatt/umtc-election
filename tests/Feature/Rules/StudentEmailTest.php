<?php

namespace Rules;

use App\Rules\StudentEmail;
use PHPUnit\Framework\TestCase;

class StudentEmailTest extends TestCase
{
    public function test_invalid_email_format(): void
    {
        $this->assertFalse((new StudentEmail)->passes(
            'email',
            'f.lastname.123456.tc@'
        ));

        $this->assertFalse((new StudentEmail)->passes(
            'email',
            '@umindanao.edu.ph'
        ));

        $this->assertFalse((new StudentEmail)->passes(
            'email',
            'f.lastname.123456.tc_umindanano.edu.ph',
        ));
    }

    public function test_no_initial(): void
    {
        $this->assertFalse((new StudentEmail)->passes(
            'email',
            'lastname.123456.tc@umindanao.edu.ph'
        ));
    }

    public function test_initial_extra_character(): void
    {
        $this->assertFalse((new StudentEmail)->passes(
            'email',
            'fextracharacter.lastname.123456.tc@umindanao.edu.ph'
        ));
    }

    public function test_not_institutional_domain(): void
    {
        $this->assertFalse((new StudentEmail)->passes(
            'email',
            'f.lastname.123456.tc@gmail.com'
        ));

        $this->assertFalse((new StudentEmail)->passes(
            'email',
            'f.lastname.123456.tc@umindanao.edu.phextracharacter'
        ));
    }

    public function test_empty_postfix_in_username(): void
    {
        $this->assertFalse((new StudentEmail)->passes(
            'email',
            'f.lastname.123456.@umindanao.edu.ph'
        ));
    }

    public function test_invalid_postfix(): void
    {
        $this->assertFalse((new StudentEmail)->passes(
            'email',
            'f.lastname.123456.invalid@umindanao.edu.ph'
        ));
    }

    public function test_student_id_contains_letter(): void
    {
        $this->assertFalse((new StudentEmail)->passes(
            'email',
            'f.lastname.12A456.tc@umindanao.edu.ph'
        ));
    }

    public function test_student_id_extra_length(): void
    {
        $this->assertFalse((new StudentEmail)->passes(
            'email',
            'f.lastname.1234567.tc@umindanao.edu.ph'
        ));
    }

    public function test_student_id_lesser_length(): void
    {
        $this->assertFalse((new StudentEmail)->passes(
            'email',
            'f.lastname.12345.tc@umindanao.edu.ph'
        ));
    }

    public function test_valid_um_main_email(): void
    {
        $this->assertTrue((new StudentEmail)->passes(
            'email',
            'f.lastname.123456@umindanao.edu.ph'
        ));
    }

    public function test_valid_um_tagum_email(): void
    {
        $this->assertTrue((new StudentEmail)->passes(
            'email',
            'f.lastname.123456.tc@umindanao.edu.ph'
        ));
    }
}
