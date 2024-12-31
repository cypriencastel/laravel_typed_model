<?php

namespace App\Models\Typed;

use ReflectionClass;
use App\Models\Typed\Contracts\MapAttribute;
use Illuminate\Database\Eloquent\Model;

trait IsMapped
{
    public static function booted()
    {
        parent::booted();
        static::retrieved(fn ($model) => self::execMapAttributes($model));
    }

    public static function execMapAttributes(Model $model)
    {
        $ref = new ReflectionClass(static::class);
        $props = $ref->getProperties();

        foreach ($props as $prop) {
            $propAttrs = $prop->getAttributes();

            foreach ($propAttrs as $attr) {
                $attrInstance = $attr->newInstance();

                if ($attrInstance instanceof MapAttribute) {
                    $attrInstance->exec($model, $prop);
                }
            }
        }
    }
}
