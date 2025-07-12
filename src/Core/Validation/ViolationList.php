<?php

namespace App\Core\Validation;

class ViolationList implements ViolationListInterface
{
    public function __construct(private array $violations = [])
    {
    }

    public function getViolations(): array
    {
        return $this->violations;
    }

    public function count(): int
    {
        return count($this->violations);
    }

    public function toArray(): array
    {
        $result = [];
        foreach ($this->violations as $violation) {
            $result[] = [
                'property' => $violation->getProperty(),
                'message' => $violation->getMessage(),
                'value' => $violation->getValue(),
            ];
        }
        return $result;
    }
}
