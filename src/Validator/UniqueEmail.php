<?php

namespace App\Validator;
use Symfony\Component\Validator\Constraint;
/**
 * @Annotation
 */
class UniqueEmail extends Constraint
{
    public $message = 'Email already exits';
    public function validatedBy()
    {
        return \get_class($this).'Validator';
    }
}