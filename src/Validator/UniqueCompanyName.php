<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;

class UniqueCompanyName extends Constraint
{
    public $message = 'CompanyName already exist';

    public function validatedBy()
    {
        return \get_class($this).'Validator';
    }
}