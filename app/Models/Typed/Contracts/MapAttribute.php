<?php

namespace App\Models\Typed\Contracts;

use Illuminate\Database\Eloquent\Model;
use ReflectionProperty;

interface MapAttribute
{
    public function exec(Model $model, ReflectionProperty $reflectedProp): mixed;
}
