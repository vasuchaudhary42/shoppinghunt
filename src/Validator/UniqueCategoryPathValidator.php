<?php


namespace App\Validator;


use App\Entity\Category;
use App\Services\CoreService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueCategoryPathValidator extends ConstraintValidator
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var CoreService
     */
    private $coreService;

    /**
     * UniqueCategoryPathValidator constructor.
     * @param EntityManagerInterface $entityManager
     * @param CoreService $coreService
     */
    public function __construct(EntityManagerInterface $entityManager, CoreService $coreService)
    {
        $this->entityManager = $entityManager;
        $this->coreService = $coreService;
    }

    /**
     * Checks if the passed value is valid.*
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        if(!$this->checkValidPath($value)){
            $this->context->buildViolation($constraint->INVALID_PATH_MESSAGE)->addViolation();
        }else if(!$this->checkUniquePath($value)){
            $this->context->buildViolation($constraint->UNIQUE_PATH_MESSAGE)->addViolation();
        }
    }

    private function checkValidPath(string $value) {
        return  preg_match('/^[0-9a-zA-Z_-]+$/',$value);

    }

    private function checkUniquePath(string $value) {
        return $this->entityManager->getRepository(Category::class)->findOneBy([
                        'Company' => $this->coreService->getCompany()->getId(),
                        'path'    => $value
                    ]) == null;
    }
}