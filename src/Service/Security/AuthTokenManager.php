<?php

namespace App\Service\Security;

use App\Core\Exception\InvalidCredentialsException;
use App\Core\Exception\NotFoundException;
use App\Entity\AuthTokenEntity;
use App\Entity\UserEntity;
use App\Dto\Security\AuthTokenDTO;
use App\Request\LoginRequest;
use App\Service\AbstractManager;
use Doctrine\ORM\EntityManagerInterface;

class AuthTokenManager extends AbstractManager
{
    private const string SECRET = 'my_secret';

    public function __construct(
        EntityManagerInterface $em,
        private UserPasswordManager $passwordManager,
    )
    {
        parent::__construct($em);
    }

    public function login(LoginRequest $request) : AuthTokenDTO {
        $user = $this->getEntityRepository(UserEntity::class)->findOneBy([
            'email' => $request->email,
        ]);

        if (null === $user) {
            throw new InvalidCredentialsException(['User not found [%s]', $request->email]);
        }

        if (false === $this->passwordManager->checkPassword($user, $request->password)) {
            throw new InvalidCredentialsException(['Invalid user credentials [%s]', $request->email]);
        }

        return $this->createToken($user);
    }

    public function createToken(UserEntity $user): AuthTokenDTO
    {
        $salt = bin2hex(random_bytes(16));
        $expiresAt = new \DateTime('+2 hours');
//        $tokenEntity = new AuthTokenEntity();
//        $tokenEntity
//            ->setUser($user)
//            ->setSalt($salt)
//            ->setExpiresAt($expiresAt);

        $tokenDto = new AuthTokenDTO(
            id: $user->getId(),
            expiresAt: $expiresAt,
            salt: $salt,
        );

        $hash = $this->generateTokenHash($tokenDto->toArray());
        $tokenDto->token = $hash;
//        $tokenEntity->setHash($hash);

//        $this->getAuthTokenRepository()->save($tokenEntity);

        return $tokenDto;
    }


    public function checkTokenValidity(AuthTokenDTO $token): bool
    {
        $payload = $token->toArray();
        $tokenHash = $this->generateTokenHash($token->toArray());

        if (false === hash_equals($payload['tk'], $tokenHash)) {
            return false; // Token hash does not match
        }

        if ($token->expiresAt < new \DateTime()) {
            return false; // Token has expired
        }

        return true;
    }

    public function decodeToken(string $token): AuthTokenDTO
    {
        $decoded = json_decode(base64_decode($token), true);
        $decoded['xp'] =  new \DateTime($decoded['xp']['date'], new \DateTimeZone($decoded['xp']['timezone']));

        return new AuthTokenDTO(
            id: $decoded['id'],
            expiresAt:  $decoded['xp'],
            salt: $decoded['sl'],
            token: $decoded['tk']
        );
    }

    public function encodeToken(AuthTokenDTO $token): string
    {
        return base64_encode(json_encode($token->toArray()));
    }


    private function generateTokenHash(array $payload): string
    {
        unset($payload['tk']);
        $derivedKey = hash('sha256', self::SECRET . $payload['sl']);
        return hash_hmac('sha256', json_encode($payload), $derivedKey);
    }

    private function getAuthTokenRepository()
    {
        return $this->getEntityRepository(AuthTokenEntity::class);
    }

}
