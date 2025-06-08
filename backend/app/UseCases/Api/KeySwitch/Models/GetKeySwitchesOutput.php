<?php

namespace App\UseCases\Api\KeySwitch\Models;

use App\UseCases\Entity;
use Illuminate\Database\Eloquent\Collection;

class GetKeySwitchesOutput extends Entity
{
    public function __construct(
        public readonly Collection $switches,
        public readonly int $count,
        public readonly string $message,
    ) {}
} 