<?php
namespace App\Controller\ShoppingControllers;

use App\Services\CoreService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class CompanyController extends AbstractController
{
    public function getCompanyDetail(CoreService $coreService)
    {
        return new JsonResponse($coreService->getCompany());
    }
}