<?php

namespace App\Core\Validation;

interface ViolationListInterface extends \Countable
{
    /**
     * Get the list of violations.
     *
     * @return Violation[]
     */
    public function getViolations(): array;

}
