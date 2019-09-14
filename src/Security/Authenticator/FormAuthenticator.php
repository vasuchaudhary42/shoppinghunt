<?php
namespace App\Security\Authenticator;
use App\Entity\User;
use App\Exception\AjaxException;
use App\Form\UserType;
use App\Services\CoreService;
use App\Services\ResponseService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class FormAuthenticator extends AbstractGuardAuthenticator
{
    private const routes = ['/en/api/admin/login', '/en/api/admin/login', '/en/api/customer/login'];
    private $route;
    /**use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\User\UserInterface;

     * @var RouterInterface
     */
    private $router;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var CoreService
     */
    private $coreService;
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var ParameterBagInterface
     */
    private $parameter;
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var ResponseService
     */
    private $responseService;
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * FormAuthenticator constructor.
     * @param SessionInterface $session
     * @param ResponseService $responseService
     * @param ContainerInterface $container
     * @param ParameterBagInterface $parameter
     * @param RouterInterface $router
     * @param EntityManagerInterface $em
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     * @param CoreService $coreService
     * @param FormFactoryInterface $formFactory
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(SessionInterface $session, ResponseService $responseService, ContainerInterface $container, ParameterBagInterface $parameter, RouterInterface $router, EntityManagerInterface $em, \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage, CoreService $coreService, FormFactoryInterface $formFactory, UserPasswordEncoderInterface $encoder)
    {
        $this->router = $router;
        $this->em = $em;
        $this->coreService = $coreService;
        $this->formFactory = $formFactory;
        $this->encoder = $encoder;
        $this->tokenStorage = $tokenStorage;
        $this->parameter = $parameter;
        $this->container = $container;
        $this->responseService = $responseService;
        $this->session = $session;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request): bool
    {
        $pathInfo       = $request->getPathInfo();
        $loginRoutes    = in_array($pathInfo, self::routes);
        $authenticated  = $this->coreService->isAuthenticated();
        if($authenticated){
            if($loginRoutes){
                $response = new JsonResponse([
                    'success' => true,
                    'message' => 'Successfully Login',
                    'user'    => $this->coreService->getResponseForCompany()
                ], Response::HTTP_OK);
                $this->responseService->sendAndDie($response);
            }
            return false;
        }
        if($loginRoutes){
            return true;
        }

        if(!in_array($pathInfo,['/admin/login']) && $request->attributes->has('_route') && in_array($request->attributes->get('_route'),['app_route_routing','app_locale_routing','app_routing'])){
            $this->session->set('Referer',$request->getRequestUri());
            return false;
        }
        AjaxException::init(AjaxException::UNAUTHORIZED, Response::HTTP_UNAUTHORIZED)->sendExceptionResponseAndExit();
        return false;

    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return AjaxException::init(AjaxException::UNAUTHORIZED, Response::HTTP_UNAUTHORIZED)
            ->getResponse();
    }

    public function getCredentials(Request $request)
    {
        $credentials = json_decode($request->getContent(), true);
        $user = new User();
        $form = $this->formFactory->create(UserType::class,$user, ['validation_groups' => ['User']]);
        $form->submit($credentials);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            return $credentials;
        }else{
            $errors = [];
            forEach($form->getErrors(true) as $error){
                $errors[$error->getOrigin()->getName()] = $error->getMessage();
            }
            AjaxException::init(AjaxException::INVALID_CREDENTIALS, Response::HTTP_FORBIDDEN,false,$errors)
            ->sendExceptionResponseAndExit();
        }
        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $user = null;
        $user = $userProvider->loadUserByUsername($credentials['email']);
        if(!isset($user))
            AjaxException::init(AjaxException::USER_NOT_FOUND,Response::HTTP_FORBIDDEN)
                ->sendExceptionResponseAndExit();
        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return $this->encoder->isPasswordValid($user,$credentials['password']);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return AjaxException::init(AjaxException::UNSUCCESSFULLY_LOGIN,Response::HTTP_FORBIDDEN)->getResponse();
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $tokenInterface, $providerKey)
    {
        $json = [
            'success' => true,
            'message' => 'Successfully Login',
            'user'    => $this->coreService->getResponseForCompany($tokenInterface->getUser())
        ];
        $response =  new JsonResponse($json, Response::HTTP_OK);
//        dump($this->session->all());die;
        if($this->session->has('Referer')){
            $response->headers->set('Referer', $this->session->get('Referer'));
        }
        return $response;

    }
    public function supportsRememberMe()
    {
        return true;
    }
}
