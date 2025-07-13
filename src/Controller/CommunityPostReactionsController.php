<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\Validation\Validator;
use App\Request\CreateCommunityPostRequest;
use App\Request\CreateUserFanTokenRequest;
use App\Request\CreateLikeOnPostRequest;
use App\Request\RemoveLikeOnPostRequest;
use App\Request\UpdateCommunityPostRequest;
use App\Service\CommunityPostReactionsManager;
use App\Service\UserCommunityPostManager;
use App\Service\UserFanTokenManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[Rest\Route('/post-reactions', name: 'route_user_reactions_')]
class CommunityPostReactionsController extends AbstractController
{
    public function __construct(private CommunityPostReactionsManager $manager, Validator $validator)
    {
        parent::__construct($validator);
    }

    #[Rest\View(statusCode:200)]
    #[Rest\Post('/like',name: 'create')]
    public function createLike(#[MapRequestPayload(validationGroups: 'n')] CreateLikeOnPostRequest $request)
    {
        $this->validate($request);
        return $this->getManager()->createLike($request);
    }

    #[Rest\View(statusCode:200)]
    #[Rest\Delete('/like',name: 'delete')]
    public function removeLike(#[MapRequestPayload(validationGroups: 'n')] RemoveLikeOnPostRequest $request)
    {
        $this->validate($request);
        return $this->getManager()->removeLike($request);
    }


    #[Rest\View(statusCode:200)]
    #[Rest\Get('/like/{postId}',name: 'list')]
    public function listLikesByPost(string $postId)
    {
        return $this->getManager()->fetchReactionsByPost($postId);
    }


    #[Rest\View(statusCode:200)]
    #[Rest\Get('/like/count/{postId}',name: 'list')]
    public function likeCountByPost(string $postId)
    {
        return [
            'count' => count($this->getManager()->fetchReactionsByPost($postId))
        ];
    }



    public function getManager(): CommunityPostReactionsManager
    {
        return $this->manager;
    }
}
