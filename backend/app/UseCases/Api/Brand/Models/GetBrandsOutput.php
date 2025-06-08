<?php

namespace App\UseCases\Api\Brand\Models;

use App\UseCases\Entity;
use Illuminate\Database\Eloquent\Collection;

class GetBrandsOutput extends Entity
{
    public function __construct(
        public readonly Collection $brands,
        public readonly string $message,
    ) {}
} 