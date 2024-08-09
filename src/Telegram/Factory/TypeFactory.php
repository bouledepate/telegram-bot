<?php

declare(strict_types=1);

namespace BDP\Telegram\Factory;

use BackedEnum;
use BDP\Kernel\Components\ValueObject\Collection;
use BDP\Kernel\Components\ValueObject\ValueObject;
use BDP\Telegram\Type\TelegramType;
use BDP\Telegram\Update\Assembly\AssemblyManagerInterface;
use BDP\Telegram\Update\DatasetType;
use BDP\Telegram\Update\Update;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;
use RuntimeException;
use function Symfony\Component\String\u;

final readonly class TypeFactory implements TypeFactoryInterface
{
    public function __construct(private AssemblyManagerInterface $assemblyManager)
    {
    }

    /**
     * @throws ReflectionException
     */
    public function produce(string $class, array $data): TelegramType
    {
        if ($this->isUpdateInstance($class)) {
            $type = $this->assemblyManager->identifyUpdate($data);
            $class = $this->assemblyManager->fetchUpdateInstance($type);
        }

        $reflection = new ReflectionClass($class);
        $instance = $reflection->newInstanceWithoutConstructor();

        foreach ($reflection->getProperties() as $property) {
            $dataKey = u($property->getName())->snake()->toString();
            $dataValue = $data[$dataKey] ?? null;

            $value = null;
            $type = $property->getType()->getName();

            if ($this->notIncludedProperty($property)) {
                continue;
            }

            if ($this->isUpdateDataProperty($property)) {
                /** @var Update $instance */
                $type = $this->getUpdateDatasetClass($reflection);
                $dataset = $data[$instance->getUpdateType()->value];
                $value = $this->produce($type, $dataset);
            }

            if ($this->isTelegramObjectProperty($property) && $dataValue !== null) {
                $value = $this->produce($type, $dataValue);
            }

            if ($this->isValueObjectProperty($property)) {
                $value = new ReflectionClass($type);
                $value = $value->newInstance($dataValue);
            }

            if ($this->isCollectionProperty($property)) {
                $value = new ReflectionClass($type);
                $collectionType = $value->getMethod('typeOf')->invoke($value->newInstanceWithoutConstructor());
                $items = array_map(fn(array $item) => $this->produce($collectionType, $item), $dataValue ?? []);
                $value = $value->newInstance($items);
            }

            if ($this->isEnumProperty($property)) {
                /** @var BackedEnum $type */
                $value = $type::tryFrom($dataValue);
            }

            $property->setValue($instance, $value ?? null);
        }

        if ($this->isCollectionInstance($class)) {
            $collectionType = $instance->typeOf();
            $items = array_map(fn (array $item) => $this->produce($collectionType, $item), $data);
            $instance = $reflection->newInstance($items);
        }

        return $instance;
    }

    private function notIncludedProperty(ReflectionProperty $property): bool
    {
        $attributes = $property->getAttributes(Skip::class);
        return !empty($attributes);
    }

    private function getUpdateDatasetClass(ReflectionClass $class): string
    {
        $attributes = $class->getAttributes(DatasetType::class);
        foreach ($attributes as $attribute) {
            /** @var DatasetType $attr */
            $attr = $attribute->newInstance();
            return $attr->getClassName();
        }
        throw new RuntimeException('DatasetType attribute is not defined.');
    }

    private function isUpdateInstance(string $className): bool
    {
        return Update::class === $className;
    }

    private function isCollectionInstance(string $className): bool
    {
        return is_subclass_of($className, Collection::class);
    }

    private function isUpdateDataProperty(ReflectionProperty $property): bool
    {
        return $property->getName() === 'updateData';
    }

    private function isValueObjectProperty(ReflectionProperty $property): bool
    {
        return is_subclass_of($property->getType()->getName(), ValueObject::class);
    }

    private function isEnumProperty(ReflectionProperty $property): bool
    {
        return is_subclass_of($property->getType()->getName(), BackedEnum::class);
    }

    private function isCollectionProperty(ReflectionProperty $property): bool
    {
        return is_subclass_of($property->getType()->getName(), Collection::class);
    }

    private function isTelegramObjectProperty(ReflectionProperty $property): bool
    {
        return is_subclass_of($property->getType()->getName(), TelegramType::class);
    }
}