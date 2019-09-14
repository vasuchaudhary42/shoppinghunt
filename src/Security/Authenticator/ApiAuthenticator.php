<?php

namespace App\Security\Authenticator;
use App\Entity\User;
use App\Exception\AjaxException;
use App\Exception\BadCredentialException;
use App\Services\CompanyService as Comias;
use App\Services\CoreService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class ApiAuthenticator extends AbstractGuardAuthenticator
{

    const X_AUTH_TOKEN = 'X-AUTH-TOKEN';
    const ACCESS_TOKEN = 'access_token';
    const TOKEN        = 'token';

    /**
     * @var TokenInterface
     */
    private $tokenStorage;
    /**
     * @var ParameterBagInterface
     */
    private $parameter;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var Comias
     */
    private $companyService;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var CoreService
     */
    private $coreService;


    /**
     * ApiAuthenticator constructor.
     * @param EntityManagerInterface $entityManager
     * @param CoreService $coreService
     * @param ParameterBagInterface $parameter
     * @param TokenStorageInterface $tokenStorage
     * @param RouterInterface $router
     */
    public function __construct(EntityManagerInterface $entityManager,CoreService $coreService, ParameterBagInterface $parameter, TokenStorageInterface $tokenStorage, RouterInterface $router)
    {
        $this->tokenStorage = $tokenStorage;
        $this->parameter = $parameter;
        $this->router = $router;
        $this->entityManager = $entityManager;
        $this->coreService = $coreService;
    }

    /**
     * Returns a response that directs the user to authenticate.
     *
     * This is called when an anonymous request accesses a resource that
     * requires authentication. The job of this method is to return some
     * response that "helps" the user start into the authentication process.
     *
     * Examples:
     *
     * - For a form login, you might redirect to the login page
     *
     *     return new RedirectResponse('/login');
     *
     * - For an API token authentication system, you return a 401 response
     *
     *     return new Response('Auth header required', 401);
     *
     * @param Request $request The request that resulted in an AuthenticationException
     * @param AuthenticationException $authException The exception that started the authentication process
     *
     * @return Response
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return AjaxException::init(AjaxException::UNAUTHORIZED, Response::HTTP_UNAUTHORIZED)->getResponse();
    }

    /**
     * Does the authenticator support the given Request?
     *
     * If this returns false, the authenticator will be skipped.
     *
     * @param Request $request
     *
     * @return bool
     */
    public function supports(Request $request)
    {
        $token = $this->tokenStorage->getToken();
        if($token && $token->isAuthenticated()){
            if($request->query->has(self::TOKEN))
                $request->query->remove(self::TOKEN);
            if($request->query->has(self::ACCESS_TOKEN))
                $request->query->remove(self::ACCESS_TOKEN);
            return false;
        }
        if($request->headers->has(self::X_AUTH_TOKEN) || $request->query->has(self::ACCESS_TOKEN) || $request->query->  has(self::TOKEN)){
            return true;
        }


        AjaxException::init(AjaxException::INVALID_TOKEN, Response::HTTP_FORBIDDEN)->sendExceptionResponseAndExit();

        return true;
    }

    /**
     * @param Request $request
     *
     * @return mixed Any non-null value
     *
     */
    public function getCredentials(Request $request)
    {

        $token = null;
        if ($request->headers->has(self::X_AUTH_TOKEN))
            $token = $request->headers->get(self::X_AUTH_TOKEN);

        if ($request->query->has(self::ACCESS_TOKEN))
            $token = $request->query->get(self::ACCESS_TOKEN);
            $request->query->remove(self::ACCESS_TOKEN);

        if ($request->query->has(self::TOKEN))
            $token = $request->query->get(self::TOKEN);
            $request->query->remove(self::TOKEN);

        if (!isset($token)){
            AjaxException::init(AjaxException::BAD_REQUEST,Response::HTTP_UNAUTHORIZED)->sendExceptionResponseAndExit();
        }
        return [
            'token' => $token
        ];
    }
    /**
    * Return a UserInterface object based on the credentials.
    * @param mixed $credentials
    * @param UserProviderInterface $userProvider
    *
    * @return UserInterface|null
    * @throws AuthenticationException
    */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $company = $this->coreService->getCompany();
        if($company){
            return $this->entityManager->getRepository(User::class)->findOneBy([
                'token' => $credentials['token'],
                'Company' => $company->getId()
            ]);
        }

        AjaxException::init(AjaxException::UNAUTHORIZED,Response::HTTP_UNAUTHORIZED);

        return null;
    }

    /**
     * @param mixed $credentials
     * @param UserInterface $user
     *
     * @return bool
     *
     * @throws AuthenticationException
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        if($user){
            return $credentials['token'] === $user->getToken();
        }else{

            return false;
        }
    }

    /**
     * Called when authentication executed, but failed (e.g. wrong username password).
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the login page or a 403 response.
     *
     * If you return null, the request will continue, but the user will
     * not be authenticated. This is probably not what you want to do.
     *
     * @param Request $request
     * @param AuthenticationException $exception
     *
     * @return Response|null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return AjaxException::init(AjaxException::INVALID_TOKEN, Response::HTTP_FORBIDDEN)->getResponse();
    }

    /**
     * Called when authentication executed and was successful!
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the last page they visited.
     *
     * If you return null, the current request will continue, and the user
     * will be authenticated. This makes sense, for example, with an API.
     *
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey The provider (i.e. firewall) key
     *
     * @return Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    /**
     * @return bool
     */
    public function supportsRememberMe()
    {
        return false;
    }
}