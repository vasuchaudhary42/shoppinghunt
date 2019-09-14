<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class UniqueDomain extends Constraint{
    public $message = 'domain already exist';
    public function validatedBy()
    {
        return \get_class($this).'Validator';
    }
}
