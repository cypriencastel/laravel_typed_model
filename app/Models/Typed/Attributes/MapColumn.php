<?php

namespace App\Models\Typed\Attributes;

use App\Models\Typed\Contracts\MapAttribute;
use Illuminate\Database\Eloquent\Model;
use Attribute;
use ReflectionProperty;

#[Attribute]
class MapColumn implements MapAttribute
{
    public function __construct(
        public readonly string $colName
    ) {
    }

    public function exec(Model $model, ReflectionProperty $reflectedProp): Model
    {
        $tableColName = $this->colName;
        $modelPropName = $reflectedProp->getName();

        $model->$modelPropName = $model->$tableColName;

        return $model;
    }
}
