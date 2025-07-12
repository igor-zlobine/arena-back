<?php

namespace App\Core\Dto\Trait;

use Symfony\Component\Uid\Uuid;

trait IdTrait
{
    private $id;

    public function __construct()
    {
        $this->generateId();
    }

    public function getId()
    {
        if (!$this->id) {
            $this->generateId();
        }
        return $this->id;
    }

    public function setId($id): self
    {
        if (is_string($id)) {
            $id = Uuid::fromString($id);
        }
        $this->id = $id;
        return $this;
    }

    public function __toString(): string
    {
        return $this->getId();
    }

    protected function generateId(): string
    {
        if ($this->id) {
            return $this->id;
        }
        $this->id = Uuid::v4();
        return $this->id;
    }
}