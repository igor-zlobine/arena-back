<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\Validation\Validator;
use App\Request\CreateFanTokenRequest;
use App\Request\CreateUserRequest;
use App\Request\LoginRequest;
use App\Service\FanTokenManager;
use App\Service\Security\AuthTokenManager;
use App\Service\UserManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[Rest\Route('/fantokens', name: 'route_fantokens_')]
class FanTokenController extends AbstractController
{
    public function __construct(private FanTokenManager $manager, Validator $validator)
    {
        parent::__construct($validator);
    }

    #[Rest\View(statusCode:200)]
    #[Rest\Post(name: 'create')]
    public function create(#[MapRequestPayload(validationGroups: 'n')] CreateFanTokenRequest $request)
    {
        $this->validate($request);
        return $this->getManager()->createFanToken($request);
    }

    #[Rest\View(statusCode:200)]
    #[Rest\Get(name: 'list')]
    public function list()
    {
        return $this->getManager()->fetchTokens();
    }

    #[Rest\View(statusCode:200)]
    #[Rest\Get('/{fantokenId}', name: 'get')]
    public function get(string $fantokenId)
    {
        return $this->getManager()->getById($fantokenId);
    }

    private function getManager(): FanTokenManager
    {
        return $this->manager;
    }

}
