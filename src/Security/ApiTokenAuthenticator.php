<?php

namespace App\Security;

use App\Repository\ApiTokenRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

/**
 * Class ApiTokenAuthenticator
 * @package App\Security
 */
class ApiTokenAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var ApiTokenRepository
     */
    private ApiTokenRepository $apiTokenRepo;

    /**
     * ApiTokenAuthenticator constructor.
     * @param ApiTokenRepository $apiTokenRepo
     */
    public function __construct(ApiTokenRepository $apiTokenRepo)
    {
        $this->apiTokenRepo = $apiTokenRepo;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request)
    {
        return $request->headers->has('Authorization')
            && 0 === strpos($request->headers->get('Authorization'), 'Bearer ');
    }

    /**
     * @param Request $request
     * @return string
     */
    public function getCredentials(Request $request)
    {
        // Skip beyond "Bearer"
        return substr($request->headers->get('Authorization'), 7);
    }

    /**
     * @param string $credentials
     * @param UserProviderInterface $userProvider
     * @return UserInterface|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = $this->apiTokenRepo->findOneBy(['token' => $credentials]);
        return $token ? $token->getUser() : null;
    }

    /**
     * @param mixed $credentials
     * @param UserInterface $user
     * @return bool|void
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        dd('checking credentials');
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return Response|void|null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // todo
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     * @return Response|void|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // todo
    }

    /**
     * @param Request $request
     * @param AuthenticationException|null $authException
     * @return Response|void
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        // todo
    }

    /**
     * @return bool|void
     */
    public function supportsRememberMe()
    {
        // todo
    }
}
