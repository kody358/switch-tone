<?php

namespace App\UseCases\Api\Brand\Models;

use App\UseCases\Entity;

class GetBrandsInput extends Entity
{
    public function __construct(
        public readonly string $sortBy = 'name',
        public readonly string $sortOrder = 'asc',
    ) {}
} 