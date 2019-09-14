<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;

class UniqueCategoryPath extends Constraint
{
    public $UNIQUE_PATH_MESSAGE = 'Path should be unique';
    public $INVALID_PATH_MESSAGE = 'Invalid Path';
    public function validatedBy()
    {
        return \get_class($this).'Validator';
    }
}