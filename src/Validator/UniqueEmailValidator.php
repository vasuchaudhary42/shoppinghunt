<?php


namespace App\Validator;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueEmailValidator extends ConstraintValidator
{
    protected $em;
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
        if(is_string($value)){
            if($this->em->getRepository(User::class)->findOneByEmail($value) !== null)
                $this->context->buildViolation($constraint->message)->addViolation();
        }else{
            $this->context->buildViolation('Name have bad format')->addViolation();
        }
    }
}