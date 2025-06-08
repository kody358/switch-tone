<?php

namespace App\UseCases\Api\Auth\Models;

use App\UseCases\Entity;

class RegisterInput extends Entity
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly string $passwordConfirmation,
    ) {}
} 