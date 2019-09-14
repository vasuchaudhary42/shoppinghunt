<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;

class ValidEmail extends Constraint
{
    public $message = 'InvalidEmail';
    public function validatedBy()
    {
        return \get_class($this).'Validator';
    }
}