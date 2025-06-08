<?php

namespace App\UseCases\Api\Brand\Models;

use App\Models\Brand;
use App\UseCases\Entity;

class GetBrandOutput extends Entity
{
    public function __construct(
        public readonly Brand $brand,
        public readonly string $message,
    ) {}
} 