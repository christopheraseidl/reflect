<?php

namespace christopheraseidl\Reflect;

use ReflectionClass;

class Reflect
{
    public static function on(object|string $target): self
    {
        return new self(
            is_object($target) ? $target : null,
            new ReflectionClass($target)
        );
    }

    public function __construct(
        private ?object $obj,
        private ReflectionClass $reflection
    ) {
    }

    public function __get(string $name): mixed
    {
        $property = $this->findProperty($name);
        $property->setAccessible(true);

        return $property->isStatic()
            ? $property->getValue()
            : $property->getValue($this->obj);
    }

    public function __set(string $name, mixed $value): void
    {
        $property = $this->findProperty($name);
        $property->setAccessible(true);

        $property->isStatic()
            ? $property->setValue(null, $value)
            : $property->setValue($this->obj, $value);
    }

    public function __call(string $name, array $params = []): mixed
    {
        $method = $this->findMethod($name);
        $method->setAccessible(true);

        return $method->isStatic()
            ? $method->invoke(null, ...$params)
            : $method->invoke($this->obj, ...$params);
    }

    private function findProperty(string $name): \ReflectionProperty
    {
        $class = $this->reflection;

        do {
            if ($class->hasProperty($name)) {
                return $class->getProperty($name);
            }
        } while ($class = $class->getParentClass());

        throw new \ReflectionException("Property '$name' does not exist.");
    }

    private function findMethod(string $name): \ReflectionMethod
    {
        $class = $this->reflection;

        do {
            if ($class->hasMethod($name)) {
                return $class->getMethod($name);
            }
        } while ($class = $class->getParentClass());

        throw new \ReflectionException("Method '$name' does not exist.");
    }
}
