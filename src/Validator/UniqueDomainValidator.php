<?php

namespace App\Validator;


use App\Entity\Company;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueDomainValidator extends ConstraintValidator
{

    private $m;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        if($this->em->getRepository(Company::class)->findOneByDomain($value) !== null){
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}