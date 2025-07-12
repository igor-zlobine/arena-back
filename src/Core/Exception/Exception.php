<?php

namespace App\Core\Exception;

class Exception extends \Exception
{
    public function __construct(string|array $message = null, int $code = 0, ?\Throwable $previous = null)
    {
        if (empty($message)) {
            $this->message = 'Unknown exception';
        } else {
            $this->setMessage(...(array)$message);
        }

        parent::__construct($this->message, $code, $previous);
    }

    public function setMessage(string $message, ...$params): self
    {
        $this->message = sprintf($message, ...$params);
        return $this;
    }
}
