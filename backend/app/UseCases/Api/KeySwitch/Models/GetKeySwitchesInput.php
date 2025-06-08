<?php

namespace App\UseCases\Api\KeySwitch\Models;

use App\UseCases\Entity;

class GetKeySwitchesInput extends Entity
{
    public function __construct(
        public readonly ?string $search = null,
        public readonly array $types = [],
        public readonly array $brands = [],
        public readonly array $priceFilters = [],
        public readonly string $sortBy = 'name',
        public readonly string $sortOrder = 'asc',
    ) {}
} 