<?php

namespace App\Core\Validation;

class ValidationFailedException extends \RuntimeException
{
    public function __construct(private readonly ViolationListInterface $payload)
    {
        parent::__construct('Validation failed');
    }

    public function getPayload(): ViolationListInterface
    {
        return $this->payload;
    }
}
