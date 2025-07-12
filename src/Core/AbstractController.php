<?php

namespace App\Core;

use App\Core\Request\RequestInterface;
use App\Core\Validation\ValidationFailedException;
use App\Core\Validation\Validator;
use App\Core\Validation\ViolationListInterface;

abstract class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    public function __construct(private readonly Validator $validator)
    {

    }

    protected function validate(RequestInterface $object, ?array $validationGroup = null): true
    {
        $violations = $this->validator->validate(data: $object, groups: $validationGroup);
        if (count($violations))
        {
            throw new ValidationFailedException($violations);
        }
        return true;
    }
}
