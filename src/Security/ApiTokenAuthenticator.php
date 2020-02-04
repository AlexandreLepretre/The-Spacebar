<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\ApiTokenRepository;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
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
     * @return User|null
     * @throws Exception
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = $this->apiTokenRepo->findOneBy(['token' => $credentials]);

        if (!$token) {
            throw new CustomUserMessageAuthenticationException('Invalid API Token');
        }

        if ($token->isExpired()) {
            throw new CustomUserMessageAuthenticationException('Token Expired');
        }

        return $token->getUser();
    }

    /**
     * @param mixed $credentials
     * @param UserInterface $user
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return JsonResponse|null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse(['message' => $exception->getMessageKey()], 401);
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // allow the request to continue
    }

    /**
     * @param Request $request
     * @param AuthenticationException|null $authException
     * @throws Exception
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        throw new Exception('Not used: entry_point from other authenticator is used');
    }

    /**
     * @return bool
     */
    public function supportsRememberMe()
    {
        return false;
    }
}
