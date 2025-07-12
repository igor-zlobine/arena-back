<?php

namespace App\Core\Validation;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\GroupSequence;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class Validator
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    /**
     * @param mixed $data
     * @param Constraint|array|null $constraints
     * @param string|array|GroupSequence|null $groups
     * @return ?Violation[]
     */
    public function validate(mixed $data, Constraint|array $constraints = null, string|GroupSequence|array|null $groups = null): ViolationListInterface
    {
        $violations = $this->validator->validate($data, $constraints, $groups);
        if (!count($violations))
        {
            return new ViolationList([]);
        }

        $result = null;
        foreach ($violations as $rawViolation) {
            $result[] = new Violation()
                ->setProperty($rawViolation->getPropertyPath())
                ->setMessage($rawViolation->getMessage())
                ->setValue($rawViolation->getInvalidValue());
        }

        return new ViolationList($result);
    }
}
