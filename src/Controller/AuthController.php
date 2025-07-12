<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\Validation\Validator;
use App\Request\CreateAuthTokenRequest;
use App\Request\CreatePaymentRequest;
use App\Service\PaymentManager;
use App\Service\Security\AuthTokenManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[Rest\Route('/auth', name: 'route_auth_')]
class AuthController extends AbstractController
{
    public function __construct(private AuthTokenManager $manager, Validator $validator)
    {
        parent::__construct($validator);
    }

    #[Rest\View(statusCode:200)]
    #[Rest\Post('/token', name: 'create_token')]
    public function createToken(#[MapRequestPayload(validationGroups: 'n')] CreateAuthTokenRequest $request)
    {
        $this->validate($request);
        return [
            'token' => $this->getManager()->forgeToken($request)
        ];
    }

    private function getManager(): AuthTokenManager
    {
        return $this->manager;
    }

}
