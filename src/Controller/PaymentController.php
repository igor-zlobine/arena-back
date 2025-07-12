<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\Validation\Validator;
use App\Request\CreateFanTokenRequest;
use App\Request\CreatePaymentRequest;
use App\Request\CreateUserRequest;
use App\Request\LoginRequest;
use App\Request\UpdateFanTokenRequest;
use App\Service\FanTokenManager;
use App\Service\PaymentManager;
use App\Service\Security\AuthTokenManager;
use App\Service\UserManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[Rest\Route('/payments', name: 'route_payments_')]
class PaymentController extends AbstractController
{
    public function __construct(private PaymentManager $manager, Validator $validator)
    {
        parent::__construct($validator);
    }

    #[Rest\View(statusCode:200)]
    #[Rest\Post(name: 'create')]
    public function create(#[MapRequestPayload(validationGroups: 'n')] CreatePaymentRequest $request)
    {
        $this->validate($request);
        return $this->getManager()->createPayment($request);
    }

    #[Rest\View(statusCode:200)]
    #[Rest\Get('/{userId}', name: 'list')]
    public function list(string $userId)
    {
        return $this->getManager()->fetchPaymentsByUserId($userId);
    }

    private function getManager(): PaymentManager
    {
        return $this->manager;
    }

}
