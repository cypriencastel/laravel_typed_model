<?php

namespace App\Models\Typed\Attributes;

use Attribute;

#[Attribute]
class Map
{
    public function __construct(
        public readonly string $colName
    ) {
    }
}
