<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\Validation\Validator;
use App\Request\CreateUserFanTokenRequest;
use App\Service\UserFanTokenManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[Rest\Route('/user-fantokens', name: 'route_user_fantokens_')]
class UserFanTokenController extends AbstractController
{
    public function __construct(private UserFanTokenManager $manager, Validator $validator)
    {
        parent::__construct($validator);
    }

    #[Rest\View(statusCode:200)]
    #[Rest\Post(name: 'create')]
    public function create(#[MapRequestPayload(validationGroups: 'n')] CreateUserFanTokenRequest $request)
    {
        $this->validate($request);
        return $this->getManager()->createUserFanToken($request);
    }

    #[Rest\View(statusCode:200)]
    #[Rest\Get('/{userId}', name: 'list')]
    public function list(string $userId)
    {
        return $this->getManager()->fetchUserFanTokens($userId);
    }

    private function getManager(): UserFanTokenManager
    {
        return $this->manager;
    }

}
