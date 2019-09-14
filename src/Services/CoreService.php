<?php

namespace App\Services;

use App\Entity\Company;
use App\Entity\User;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
class CoreService
{

    /**
     * @var CompanyService
     */
    private $companyService;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * CoreService constructor.
     * @param TokenStorageInterface $tokenStorage
     * @param EntityManagerInterface $em
     * @param CompanyService $companyService
     */
    function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $em, CompanyService $companyService){
        $this->companyService = $companyService;
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @return Company
     */
    public function getCompany()
    {
        return $this->companyService->getCompany();
    }

    function getResponseForCompany(){
        $user = $this->tokenStorage->getToken()->getUser();
        return [
            'name'          => $user->getName(),
            'companyName'   => $user->getCompany()->getCompanyName(),
            'domain'        => $user->getCompany()->getDomain(),
            'email'         => $user->getEmail(),
            'roles'         => $user->getRoles(),
            'token'         => $user->getToken()
        ];
    }

    function getCompanyAccountResponse(TokenStorageInterface $tokenStorage) {
        $token = $tokenStorage->getToken();

        if ($token->isAuthenticated() && !($token instanceof AnonymousToken)){
            return new JsonResponse([
                'name'          => $token->getUser()->getName(),
                'companyName'   => $token->getUser()->getCompany()->getCompanyName(),
                'email'         => $token->getUser()->getEmail(),
                'domain'        => $token->getUser()->getCompany()->getDomain(),
                'roles'         => current($token->getRoleNames())
            ], Response::HTTP_OK);
        }
        return new JsonResponse('', Response::HTTP_UNAUTHORIZED);
    }

    function isAuthenticated(){
        $token = $this->tokenStorage->getToken();
        return isset($token) && $token->isAuthenticated() && !($token instanceof AnonymousToken);
    }
}