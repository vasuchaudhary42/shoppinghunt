<?php


namespace App\Controller\ShoppingControllers;


use App\Services\CompanyService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;

class BaseController extends AbstractController
{
    /**
     * @var CompanyService
     */
    private $companyService;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * BaseController constructor.
     * @param EntityManagerInterface $entityManager
     * @param CompanyService $companyService
     */
    function __construct(EntityManagerInterface $entityManager, CompanyService $companyService)
    {
        $this->companyService = $companyService;
        $this->entityManager = $entityManager;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    protected function getFormErrors(FormInterface $form) : array
    {
        $errors = [];
        forEach($form->getErrors(true) as $error){
            array_push($errors,[$error->getOrigin()->getName() => $error->getMessage()]) ;
        }
        return $errors;
    }

    protected function getCompany(){
        return $this->companyService->getCompany();
    }
}