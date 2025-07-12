<?php
namespace App\Dto\Security;

use DateTime;

class AuthTokenDTO {
    public string $id;
    public DateTime $expiresAt;
    public string $salt;
    public ?string $token = null;

    public function __construct(string $id, DateTime $expiresAt, string $salt, ?string $token = null ) {
        $this->id = $id;
        $this->token = $token;
        $this->salt = $salt;
        $this->expiresAt = $expiresAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'tk' => $this->token,
            'sl' => $this->salt,
            'xp' => $this->expiresAt,
        ];
    }

}
