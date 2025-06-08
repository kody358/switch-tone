<?php

namespace App\UseCases\Api\Auth\Models;

use App\Models\User;
use App\UseCases\Entity;

class RegisterOutput extends Entity
{
    public function __construct(
        public readonly User $user,
        public readonly string $token,
        public readonly string $message,
    ) {}
} 