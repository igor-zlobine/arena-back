<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Request\CreateUserRequest;
use App\Request\LoginRequest;
use App\Service\Security\AuthTokenManager;
use App\Service\UserManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[Rest\Route('/user', name: 'route_user_')]
class UserController extends AbstractController
{
    #[Rest\View(statusCode:200)]
    #[Rest\Get('/{userId}', name: 'get')]
    public function userGet(string $userId, UserManager $userManager)
    {

        $userEntity = $userManager->getUserById($userId);
        if (!$userEntity) {
            throw $this->createNotFoundException('User not found');
        }
        return $userEntity;
    }

    #[Rest\View(statusCode:200)]
    #[Rest\Post(name: 'create')]
    public function userCreate(#[MapRequestPayload(validationGroups: 'n')] CreateUserRequest $request, UserManager $userManager)
    {
        $this->validate($request);
        $userEntity = $userManager->createUser($request);
        return $userEntity;
    }

//    #[Rest\View(statusCode:200)]
//    #[Rest\Post('/login', name: 'login')]
//    public function userLogin(#[MapRequestPayload(validationGroups: 'n')] LoginRequest $request, AuthTokenManager $authTokenManager)
//    {
//        $this->validate($request);
//        $token = $authTokenManager->login($request);
//        $encodedToken = $authTokenManager->encodeToken($token);
//        return [
//            'token' => $encodedToken,
//        ];
//    }

}
