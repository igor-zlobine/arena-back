<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\Validation\Validator;
use App\Entity\CommunityEntity;
use App\Request\CreateCommunityRequest;
use App\Request\CreateUserRequest;
use App\Request\LoginRequest;
use App\Request\UpdateCommunityRequest;
use App\Service\CommunityManager;
use App\Service\Security\AuthTokenManager;
use App\Service\UserManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[Rest\Route('/communities', name: 'route_community_')]
class CommunityController extends AbstractController
{
    public function __construct(
        private CommunityManager $communityManager,
        Validator $validator,
    ) {
        parent::__construct($validator);
    }

    #[Rest\View(statusCode:200)]
    #[Rest\Post(name: 'create')]
    public function create(#[MapRequestPayload(validationGroups: 'n')] CreateCommunityRequest $request)
    {
        $this->validate($request);
        return $this->getManager()->createCommunity($request);
    }

    #[Rest\View(statusCode:200)]
    #[Rest\Get('/{communityId}', name: 'get')]
    public function get(string $communityId)
    {
        return $this->getManager()->getById($communityId);
    }

    #[Rest\View(statusCode:200)]
    #[Rest\Put('/{communityId}', name: 'update')]
    public function update(#[MapRequestPayload(validationGroups: 'n')] UpdateCommunityRequest $request, string $communityId)
    {
        $request->id = $communityId;
        return $this->getManager()->updateCommunity($request);
    }

    #[Rest\View(statusCode:200)]
    #[Rest\Get(name: 'fetch_all')]
    public function list()
    {
        return $this->getManager()->fetchAll();
    }


    private function getManager(): CommunityManager
    {
        return $this->communityManager;
    }

}
