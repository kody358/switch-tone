<?php

namespace App\UseCases\Api\Auth\Models;

use App\UseCases\Entity;

class LoginInput extends Entity
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly bool $remember = false,
    ) {}
} 