<?php

namespace App\UseCases\Api\Brand\Models;

use App\UseCases\Entity;

class GetBrandInput extends Entity
{
    public function __construct(
        public readonly string $slugOrId,
    ) {}
} 