<?php

declare(strict_types=1);

namespace BDP\Kernel\Components\Config\Structure;

use BDP\Kernel\Components\Environment\Constant;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

abstract readonly class AbstractEnvConfig implements EnvConfig
{
    /** @throws ReflectionException */
    public static function collectFrom(array $data): EnvConfig
    {
        $reflection = new ReflectionClass(static::class);
        $instance = $reflection->newInstanceWithoutConstructor();

        $constantMap = $instance->constantMap();
        foreach ($reflection->getProperties() as $property) {
            /** @var Constant $constant */
            $constant = $constantMap[$property->getName()] ?? null;
            if ($constant === null) {
                $value = null;
            } else {
                $value = $data[$constant->name] ?? null;
                if ($value !== null) {
                    $type = $property->getType()->getName();
                    $value = self::typecast($value, $type);
                }
            }
            $property->setValue($instance, $value);
        }

        return $instance;
    }

    final public function getValue(Constant $constant): mixed
    {
        $property = array_search($constant, $this->constantMap());
        if ($property === false) {
            return null;
        }
        if (property_exists($this, $property)) {
            $property = new ReflectionProperty($this, $property);
            return $property->getValue($this);
        }
        return null;
    }

    abstract protected function constantMap(): array;

    private static function typecast(mixed $value, string $type): string|int|bool|float
    {
        return match ($type) {
            'string' => (string)$value,
            'int' => intval($value),
            'bool' => boolval($value),
            'float' => floatval($value),
        };
    }
}