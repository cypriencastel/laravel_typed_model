<?php

namespace App\Models\Typed;

use ReflectionClass;
use ReflectionAttribute;
use App\Models\Typed\Attributes\Map;

trait IsMapped
{
    public static function booted()
    {
        parent::booted();
        static::retrieved(function($model) {
            $ref = new ReflectionClass(static::class);
            $mappedProps = self::getPropertiesWithAttr($ref, Map::class);

            foreach ($mappedProps as $prop) {
                $model->{$prop->getNewName()} = $model->{$prop->getOriginalName()};
            }
        });
    }

    public static function getPropertiesWithAttr(ReflectionClass $cl, string $attrName): array
    {
        $props = $cl->getProperties();
        $mappedProps = [];

        foreach ($props as $prop) {
            foreach ($prop->getAttributes() as $attr) {
                if ($attr->getName() === $attrName) {
                    $mappedProp = new MappedProp();
                    $mappedProp->setOriginalName(self::getOriginalName($attr));
                    $mappedProp->setNewName($prop->name);
    
                    $mappedProps[] = $mappedProp;
                }
            }
        }

        return $mappedProps;
    }

    private static function getOriginalName(ReflectionAttribute $attr): string
    {
        if (array_key_exists('colName', $attr->getArguments())) {
            return $attr->getArguments()['colName'];
        }

        return $attr->getArguments()[0];
    }
}

class MappedProp
{
    private string $originalName;
    private string $newName;

    public function setOriginalName(string $name): void
    {
        $this->originalName = $name;
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function setNewName(string $name)
    {
        $this->newName = $name;
    }

    public function getNewName(): string
    {
        return $this->newName;
    }
}
