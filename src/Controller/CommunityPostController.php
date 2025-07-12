<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\Validation\Validator;
use App\Request\CreateCommunityPostRequest;
use App\Request\CreateUserFanTokenRequest;
use App\Request\UpdateCommunityPostRequest;
use App\Service\UserCommunityPostManager;
use App\Service\UserFanTokenManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[Rest\Route('/posts', name: 'route_community_posts_')]
class CommunityPostController extends AbstractController
{
    public function __construct(private UserCommunityPostManager $manager, Validator $validator)
    {
        parent::__construct($validator);
    }

    #[Rest\View(statusCode:200)]
    #[Rest\Post(name: 'create')]
    public function create(#[MapRequestPayload(validationGroups: 'n')] CreateCommunityPostRequest $request)
    {
        $this->validate($request);
        return $this->getManager()->createPost($request);
    }

    #[Rest\View(statusCode:200)]
    #[Rest\Put('/{postId}', name: 'update')]
    public function update(#[MapRequestPayload(validationGroups: 'n')] UpdateCommunityPostRequest $request, string $postId)
    {
        $request->id = $postId;
        $this->validate($request);
        return $this->getManager()->updatePost($request);
    }

    #[Rest\View(statusCode:200)]
    #[Rest\Get('/{communityId}', name: 'list_by_community')]
    public function listByCommunity(string $communityId)
    {
        return $this->getManager()->fetchPostByCommunity($communityId);
    }

    private function getManager(): UserCommunityPostManager
    {
        return $this->manager;
    }

}
