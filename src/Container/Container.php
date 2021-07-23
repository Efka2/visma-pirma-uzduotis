<?php

namespace Syllabus\Container;

use http\Exception\RuntimeException;
use Psr\Container\ContainerInterface;
use ReflectionClass;

class Container implements ContainerInterface
{
    private array $services = [];

    public function set(string $id, callable $factory)
    {
        $this->services[$id] = $factory;
    }

    public function get(string $id)
    {
        if (isset($this->services[$id])) {
            return $this->services[$id]($this);
        }

        $reflection = new ReflectionClass($id);

        $dependencies = $this->buildDependencies($reflection);
        return $reflection->newInstanceArgs($dependencies);
    }

    public function has(string $id): bool
    {
        return in_array($id, $this->services);
    }

    private function buildDependencies(ReflectionClass $reflection): array
    {
        $constructor = $reflection->getConstructor();
        if (!$constructor) {
            return [];
        }
        $params = $constructor->getParameters();
        return array_map(
            function ($parameter) {
                if (!$type = $parameter->getType()) {
                    throw new RuntimeException();
                }
                return $this->get($type);
            },
            $params
        );
    }
}
