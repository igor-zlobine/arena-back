<?php

namespace App\Service\Security;

use App\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

readonly class AccessTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(
        private AuthTokenManager $authTokenManager,
    ) {
    }

    public function getUserBadgeFrom(string $accessToken): UserBadge
    {

        $authToken = $this->authTokenManager->decodeToken($accessToken);
        if (false === $this->authTokenManager->checkTokenValidity($authToken)) {
            throw new AccessDeniedException('Invalid or expired access token.');
        }

        return new UserBadge($authToken->id);
    }
}
