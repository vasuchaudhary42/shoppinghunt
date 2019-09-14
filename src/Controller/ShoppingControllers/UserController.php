<?php


namespace App\Controller\ShoppingControllers;

use App\Entity\Company;
use App\Entity\User;
use App\Form\RegistrationType;
use App\Services\CoreService;
use App\Services\TokenGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

class UserController extends BaseController
{
    public function companyRegistrationAction(TokenGenerator $tokenGenerator,Request $request,EntityManagerInterface $em,UserPasswordEncoderInterface $encoder){
        $params = json_decode($request->getContent(), true);

        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user,['validation_groups' => ['Registration']]);

        $form->submit($params);
        $form->handleRequest($request);
        $errors = [];
        if ($form->isSubmitted() && $form->isValid()){
            $user->setPassword($encoder->encodePassword($user,$user->getPassword()));
            $user->setRoles(['ROLE_COMPANY']);
            $user->setToken($tokenGenerator->generateToken());
            $company = new Company();
            $company->setCompanyName($user->companyName);
            $company->setDomain($user->domain);
            $company->setIsActive(1);
            $company->setIsEmailConfirmationPending(1);
            $em->persist($company);
            $user->setCompany($company);
            $em->persist($user);
            $em->flush();
        }else{
            return new JsonResponse(['success' => false,'message' => '', 'errors' => $this->getFormErrors($form)],
                Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse(['success' => true , 'message' => 'Register Successfully']);
    }

    public function loginAction()
    {
        return new JsonResponse([]);
    }

    public function logoutAction()
    {
    }
    public function account(Request $request,CoreService $coreService,TokenStorageInterface $tokenStorage){
        return $coreService->getCompanyAccountResponse($tokenStorage);
    }
}
